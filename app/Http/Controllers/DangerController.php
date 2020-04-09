<?php

namespace App\Http\Controllers;

use App\Danger;
use App\Water;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class DangerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['create', 'store', 'edit', 'update', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Water $water
     * @return View
     */
    public function index(Water $water): View
    {
        return view('sites.danger.index')
            ->with('water', $water);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Water $water
     * @return View
     */
    public function create(Water $water): View
    {
        return view('sites.danger.create')
            ->with('water', $water);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Water $water
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Water $water): RedirectResponse
    {
        $this->validate(request(), [
            'marker' => 'required|string',
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $water->dangers()->save(
            new Danger(request(['marker', 'name', 'description']))
        );

        session()->flash(
            'message', 'Die Gefahrenstelle wurde erstellt.'
        );

        return redirect('water/' . $water->id . '/danger');
    }

    /**
     * Display the specified resource.
     *
     * @param Water $water
     * @param Danger $danger
     * @return View
     */
    public function show(Water $water, Danger $danger): View
    {
        return view('sites.danger.show')
            ->with('danger', $danger);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Water $water
     * @param Danger $danger
     * @return View
     */
    public function edit(Water $water, Danger $danger): View
    {
        return view('sites.danger.edit')
            ->with('danger', $danger);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Water $water
     * @param Danger $danger
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Water $water, Danger $danger): RedirectResponse
    {
        $this->validate(request(), [
            'marker' => 'required|string',
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $danger->update(
            request(['marker', 'name', 'description'])
        );

        session()->flash(
            'message', 'Die Gefahrenstelle wurde aktualisiert.'
        );

        return redirect('water/' . $water->id . '/danger/' . $danger->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Water $water
     * @param Danger $danger
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Water $water, Danger $danger): RedirectResponse
    {
        $danger->delete();

        session()->flash(
            'message', 'Die Gefahrenstelle wurde gelöscht.'
        );

        return redirect('water/' . $water->id . '/danger');
    }

    /**
     * Return all waters in the viewing area
     *
     * @param Water $water
     * @return Response
     */
    public function markers(Water $water): Response
    {
        $markers = $water->dangers()->select(['id', 'name', 'marker'])->get()->toJson();

        return response($markers, 200)
            ->header('Content-Type', 'text/json');
    }
}
