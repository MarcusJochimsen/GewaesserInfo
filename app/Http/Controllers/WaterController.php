<?php

namespace App\Http\Controllers;

use App\Current;
use App\User;
use App\Water;
use Barryvdh\DomPDF\PDF;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class WaterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['create', 'store', 'edit', 'update', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        return view('sites.water.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('sites.water.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(): RedirectResponse
    {
        $this->validate(request(), [
            'name' => 'required|string',
            'description' => 'nullable|string',
            'dangertext' => 'nullable|string',
            'location' => 'nullable|string',
            'contact' => 'nullable|string',
            'deep' => 'required|integer|min:0',
            'current_id' => 'required|integer',
            'currentV' => 'required|integer|min:0',
            'center_lat' => 'required',
            'center_lng' => 'required',
            'bounds' => 'required',
        ]);

        /**
         * @var User $user
         */
        $user = auth()->user();
        $user->waters()->save(
            new Water(request([
                'name',
                'description',
                'dangertext',
                'contact',
                'location',
                'deep',
                'current_id',
                'currentV',
                'center_lat',
                'center_lng',
                'bounds'
            ]))
        );

        session()->flash(
            'message',
            'Das Gewässer wurde erstellt.'
        );

        return redirect('water');
    }

    /**
     * Display the specified resource.
     *
     * @param Water $water
     * @return View
     */
    public function show(Water $water): View
    {
        return view('sites.water.show')
            ->with('water', $water)
            ->with('current', Current::where('id', $water->currentId)->get());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Water $water
     * @return Response
     */
    public function edit(Water $water): View
    {
        return view('sites.water.edit')
            ->with('water', $water);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Water $water
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Water $water): RedirectResponse
    {
        $this->validate(request(), [
            'name' => 'required|string',
            'description' => 'nullable|string',
            'dangertext' => 'nullable|string',
            'location' => 'nullable|string',
            'contact' => 'nullable|string',
            'deep' => 'required|integer|min:0',
            'current_id' => 'required|integer',
            'currentV' => 'required|integer|min:0',
            'center_lat' => 'required',
            'center_lng' => 'required',
            'bounds' => 'required',
        ]);

        $water->update(
            request([
                'name',
                'description',
                'dangertext',
                'contact',
                'location',
                'deep',
                'current_id',
                'currentV',
                'center_lat',
                'center_lng',
                'bounds'
            ])
        );

        session()->flash(
            'message',
            'Das Gewässer wurde aktualisiert.'
        );

        return redirect('water/' . $water->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Water $water
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Water $water): RedirectResponse
    {
        $water->delete();

        session()->flash(
            'message',
            'Das Gewässer wurde gelöscht.'
        );

        return redirect('water');
    }

    /**
     * Return all waters in the viewing area
     *
     * @param Request $request
     * @return Response
     */
    public function markers(Request $request): Response
    {
        $markers = DB::table('waters')
            ->select(['id', 'name', 'center_lat', 'center_lng'])
            ->whereBetween('center_lat', [$request->query('south'), $request->query('north')])
            ->whereBetween('center_lng', [$request->query('west'), $request->query('east')])
            ->get()
            ->toJson();

        return response($markers, 200)
            ->header('Content-Type', 'text/json');
    }

    public function print(Water $water)
    {
        return view('sites.water.print')
            ->with('water', $water);

//        $content =  view('sites.water.print_css')
//            ->with('water', $water)
//            ->toHtml();
//        return response($content, 200)
//            ->header('Content-Type', 'application/pdf');

//        /** @var PDF $pdf */
//        $pdf = App::make('dompdf.wrapper');
//        return $pdf->loadView('sites.water.print', compact('water'))
//            ->setPaper('a3', 'landscape')
//            ->stream();
    }
}
