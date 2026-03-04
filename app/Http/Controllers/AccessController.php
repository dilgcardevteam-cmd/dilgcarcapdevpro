<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;

class AccessController extends Controller
{
    protected function authorizeSuperAdmin(): void
    {
        if (!auth()->check() || auth()->user()->role !== 'super_admin') {
            abort(403);
        }
    }

    public function update(Request $request)
    {
        $this->authorizeSuperAdmin();
        $matrix = (array) $request->input('matrix', []);
        DB::beginTransaction();
        try {
            foreach ($matrix as $roleId => $permIds) {
                $role = Role::find($roleId);
                if (!$role) continue;
                $ids = array_map('intval', array_keys(array_filter($permIds ?? [])));
                $role->permissions()->sync($ids);
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('dashboard', ['tab' => 'access-management'])->with('error_access', 'Failed to update permissions: '.$e->getMessage());
        }
        return redirect()->route('dashboard', ['tab' => 'access-management'])->with('success_access', 'Permissions updated.');
    }
}
