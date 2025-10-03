<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::withCount('roles')->orderBy('name')->paginate(10);
        return view('permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
        ]);

        $permission = Permission::create([
            'name' => $data['name'],
            'guard_name' => 'web'
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Creación de permiso',
            'description' => 'Permiso creado: "' . $permission->name . '"',
        ]);

        return redirect()->route('permissions.index')
            ->with('status', 'Permiso creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        $permission->load('roles');
        return view('permissions.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        return view('permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update(['name' => $data['name']]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Actualización de permiso',
            'description' => 'Permiso actualizado: "' . $permission->name . '"',
        ]);

        return redirect()->route('permissions.index')
            ->with('status', 'Permiso actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permissionName = $permission->name;
        
        $permission->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Eliminación de permiso',
            'description' => 'Permiso eliminado: "' . $permissionName . '"',
        ]);

        return redirect()->route('permissions.index')
            ->with('status', 'Permiso eliminado correctamente.');
    }
}