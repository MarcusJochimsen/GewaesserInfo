<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return View
     */
    public function show($user): View
    {
        return view('sites.user.show')
            ->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return View
     */
    public function edit(): View
    {
        return view('sites.user.edit')
            ->with('user', auth()->user());
    }

    /**
     * Update the specified resource in storage.
     *
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(): RedirectResponse
    {
        $this->validate(request(), [
            'entity_id' => 'required|integer',
            'name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string',
            'street' => 'nullable|string',
            'number' => 'nullable|string',
            'zip' => 'nullable|string',
            'city' => 'nullable|string',
            'fon' => 'nullable|string',
        ]);

        /**
         * @var User $user
         */
        $user = auth()->user();
        $user->update(
            request(['entity_id', 'name', 'email', 'street', 'number', 'zip', 'city', 'fon'])
        );

        $user->update(
            ['password' => Hash::make(request(['password']))]
        );

        session()->flash(
            'message', 'Deine Daten wurden aktualisiert.'
        );

        return redirect('user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return RedirectResponse
     */
    public function destroy(): RedirectResponse
    {
        // Todo: Delete User
//        auth()->user()->delete();
//
//        session()->flash(
//            'message', 'Deine Daten wurden gelöscht.'
//        );

        return redirect('logout');
    }
}
