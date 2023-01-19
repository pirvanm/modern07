<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;

class PermissionController
{
    /**
     * Display the password reset link request view.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('components.permission');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param  Request  $request
     * @return RedirectResponse
     *
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'guard_name' => 'required'
        ]);

        try {
            Permission::create($validatedData);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

        return redirect()->back();

    }

}
