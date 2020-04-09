<?php

namespace App\Http\Controllers;

use App\Entity;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class EntityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        $entitys = Entity::all();

        return view('entity.index')
            ->with('entitys', $entitys);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return view('entity.create');
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
            'division_id' => 'required|integer',
            'name' => 'required|string',
            'street' => 'nullable|string',
            'number' => 'nullable|string',
            'zip' => 'nullable|string',
            'city' => 'nullable|string',
        ]);

        auth()->user()->entity()->save(
            new Entity(request(['division_id', 'name', 'street', 'number', 'zip', 'city']))
        );

        session()->flash(
            'message',
            'Die Organisation wurde erstellt.'
        );

        return redirect('entity');
    }

    /**
     * Display the specified resource.
     *
     * @param Entity $entity
     * @return Response
     */
    public function show(Entity $entity): Response
    {
        return view('entity.show')
            ->with('entity', $entity);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Entity $entity
     * @return Response
     */
    public function edit(Entity $entity): Response
    {
        return view('entity.edit')
            ->with('entity', $entity);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Entity $entity
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Entity $entity): RedirectResponse
    {
        $this->validate(request(), [
            'division_id' => 'required|integer',
            'name' => 'required|string',
            'street' => 'nullable|string',
            'number' => 'nullable|string',
            'zip' => 'nullable|string',
            'city' => 'nullable|string',
        ]);

        $entity->update(
            request(['division_id', 'name', 'street', 'number', 'zip', 'city'])
        );

        session()->flash(
            'message',
            'Die Organisation wurde aktualisiert.'
        );

        return redirect('entity/' . $entity->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Entity $entity
     * @return Response
     * @throws Exception
     */
    public function destroy(Entity $entity): Response
    {
        $entity->delete();

        session()->flash(
            'message',
            'Die Organisation wurde gelöscht.'
        );

        return redirect('entity');
    }
}
