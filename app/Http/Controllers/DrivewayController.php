<?php

namespace App\Http\Controllers;

use App\Driveway;
use App\Water;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class DrivewayController extends Controller
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
        return view('sites.driveway.index')
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
        return view('sites.driveway.create')
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
            'description' => 'nullable|string',
            'name' => 'required|string',
        ]);

        $water->driveways()->save(
            new Driveway(request(['marker', 'description', 'name']))
        );

        session()->flash(
            'message', 'Die Zufahrt wurde erstellt.'
        );

        return redirect('water/' . $water->id . '/driveway');
    }

    /**
     * Display the specified resource.
     *
     * @param Water $water
     * @param Driveway $driveway
     * @return View
     */
    public function show(Water $water, Driveway $driveway): View
    {
        return view('sites.driveway.show')
            ->with('driveway', $driveway);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Water $water
     * @param Driveway $driveway
     * @return View
     */
    public function edit(Water $water, Driveway $driveway):View
    {
        return view('sites.driveway.edit')
            ->with('driveway', $driveway);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Water $water
     * @param Driveway $driveway
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Water $water, Driveway $driveway): RedirectResponse
    {
        $this->validate(request(), [
            'marker' => 'required|string',
            'description' => 'nullable|string',
            'name' => 'required|string',
        ]);

        $driveway->update(
            request(['marker', 'description', 'name'])
        );

        session()->flash(
            'message', 'Die Zufahrt wurde aktualisiert.'
        );

        return redirect('water/' . $water->id . '/driveway/' . $driveway->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Water $water
     * @param Driveway $driveway
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Water $water, Driveway $driveway): RedirectResponse
    {
        $driveway->delete();

        session()->flash(
            'message', 'Die Zufahrt wurde gelöscht.'
        );

        return redirect('water/' . $water->id . '/driveway');
    }

    /**
     * Return all waters in the viewing area
     *
     * @param Water $water
     * @return Response
     */
    public function markers(Water $water): Response
    {
        $markers = $water->driveways()->select(['id', 'name', 'marker'])->get()->toJson();

        return response($markers, 200)
            ->header('Content-Type', 'text/json');
    }
}
