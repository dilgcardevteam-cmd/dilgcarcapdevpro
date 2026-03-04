<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected function authorizeSuperAdmin(): void
    {
        if (!auth()->check() || auth()->user()->role !== 'super_admin') {
            abort(403);
        }
    }

    public function index()
    {
        $this->authorizeSuperAdmin();
        $roles = Role::orderBy('name')->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function store(Request $request)
    {
        $this->authorizeSuperAdmin();
        $validated = $request->validate([
            'name' => 'required|string|max:100|regex:/^[a-z0-9_]+$/|unique:roles,name',
            'display_name' => 'nullable|string|max:100',
        ]);
        Role::create($validated);
        return redirect()->route('dashboard', ['tab' => 'roles-management'])->with('success_roles', 'Role created.');
    }

    public function update(Request $request, Role $role)
    {
        $this->authorizeSuperAdmin();
        $validated = $request->validate([
            'name' => 'required|string|max:100|regex:/^[a-z0-9_]+$/|unique:roles,name,' . $role->id,
            'display_name' => 'nullable|string|max:100',
        ]);
        $oldName = $role->name;
        $role->update($validated);
        if (isset($validated['name']) && $validated['name'] !== $oldName) {
            User::where('role', $oldName)->update(['role' => $validated['name']]);
        }
        return redirect()->route('dashboard', ['tab' => 'roles-management'])->with('success_roles', 'Role updated.');
    }

    public function destroy(Role $role)
    {
        $this->authorizeSuperAdmin();
        $role->delete();
        return redirect()->route('dashboard', ['tab' => 'roles-management'])->with('success_roles', 'Role deleted.');
    }
}
