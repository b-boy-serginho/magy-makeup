<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth; 


class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class);
    }

    public function index(): View
    {
        $users = User::paginate();

        return view('users.index', compact('users'));
    }

    public function editRoles(User $user): View
    {
        // Listas para checkboxes
        $roles = Role::orderBy('name')->get(['id', 'name']);
        $permissions = Permission::orderBy('name')->get(['id', 'name']);

        // IDs actuales del usuario
        $userRoleIds = $user->roles->pluck('id')->toArray();
        $userPermissionIds = $user->permissions->pluck('id')->toArray();

        return view('users.edit-roles', compact(
            'user', 'roles', 'permissions', 'userRoleIds', 'userPermissionIds'
        ));
    }

 public function updateRoles(Request $request, User $user)
    {
        // 1) Validación y normalización
        $data = $request->validate([
            'roles' => ['nullable','array'],
            'roles.*' => ['integer', 'exists:roles,id'],
            'permissions' => ['nullable','array'],
            'permissions.*' => ['integer', 'exists:permissions,id'],
        ]);

        $newRoleIds = $data['roles'] ?? [];
        $newPermIds = $data['permissions'] ?? [];

        // 2) Snapshot ANTES de sincronizar
        $oldRoleIds = $user->roles()->pluck('id')->toArray();
        $oldPermIds = $user->permissions()->pluck('id')->toArray();

        // 3) Sincronizar usando el guard correcto (ajusta si tu guard no es 'web')
        $roles = Role::whereIn('id', $newRoleIds)->where('guard_name', 'web')->get();
        $perms = Permission::whereIn('id', $newPermIds)->where('guard_name', 'web')->get();

        $user->syncRoles($roles);
        $user->syncPermissions($perms);

        // 4) Detectar cambios reales
        $rolesChanged = $this->idsChanged($oldRoleIds, $newRoleIds);
        $permsChanged = $this->idsChanged($oldPermIds, $newPermIds);

        // 5) Registrar en bitácora si hubo cambios
        if ($rolesChanged || $permsChanged) {
            $detalles = [];

            if ($rolesChanged) {
                $detalles[] = sprintf(
                    'Roles: [%s] -> [%s]',
                    implode(',', $oldRoleIds),
                    implode(',', $newRoleIds)
                );
            }

            if ($permsChanged) {
                $detalles[] = sprintf(
                    'Permisos: [%s] -> [%s]',
                    implode(',', $oldPermIds),
                    implode(',', $newPermIds)
                );
            }

            ActivityLog::create([
                'user_id'     => Auth::id(),
                'action'      => 'Actualización de roles/permisos',
                'description' => 'Usuario afectado: '.$user->name.' | '.implode(' | ', $detalles),
            ]);
        }

        return redirect()
            ->route('users.index')
            ->with('status', 'Roles y permisos actualizados correctamente.');
    }

   public function bitacora(Request $request): View
    {
        $activityLogs = ActivityLog::with('user')
            ->when($request->filled('action'), function($query) use ($request) {
                $action = $request->input('action');
                return $query->where('action', 'like', '%'.$action.'%');
            })
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('users.bitacora', compact('activityLogs'));
    }

    /**
     * Compara arrays de IDs ignorando orden y duplicados.
     */
    private function idsChanged(array $old, array $new): bool
    {
        sort($old);
        sort($new);
        return $old !== $new;
    }
}
