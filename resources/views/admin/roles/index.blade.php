@php
    $canManage = auth()->check() && in_array(auth()->user()->role, ['admin','super_admin']);
@endphp
<div class="content-section active">
    <div class="insight-panel">
        <div class="insight-panel-header">
            <h2>Roles Management</h2>
            <span>Create and edit roles in the database</span>
        </div>
        @if(session('success'))
            <div style="background:#e6fffa;color:#065f46;padding:12px;border-radius:8px;margin-bottom:12px">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div style="background:#fff7ed;color:#9a3412;padding:12px;border-radius:8px;margin-bottom:12px">
                {{ $errors->first() }}
            </div>
        @endif
        @if(!$canManage)
            <div style="background:#fee2e2;color:#7f1d1d;padding:12px;border-radius:8px">You are not authorized to manage roles.</div>
        @else
            <div style="display:flex;gap:24px;align-items:flex-start;flex-wrap:wrap">
                <div style="flex:1;min-width:280px">
                    <h3 style="margin-top:0">Add Role</h3>
                    <form method="POST" action="{{ route('admin.roles.store') }}" style="display:grid;gap:12px">
                        @csrf
                        <label>
                            <div>Name</div>
                            <input type="text" name="name" placeholder="e.g. super_admin" style="width:100%;padding:10px;border:1px solid #e5eef7;border-radius:8px">
                        </label>
                        <label>
                            <div>Display Name (optional)</div>
                            <input type="text" name="display_name" placeholder="e.g. Super Admin" style="width:100%;padding:10px;border:1px solid #e5eef7;border-radius:8px">
                        </label>
                        <button type="submit" style="background:#0B2C74;color:#fff;border:none;padding:10px 16px;border-radius:8px;cursor:pointer">Create Role</button>
                    </form>
                </div>
                <div style="flex:2;min-width:320px">
                    <h3 style="margin-top:0">Existing Roles</h3>
                    <div style="border:1px solid #e5eef7;border-radius:12px;overflow:hidden">
                        <table style="width:100%;border-collapse:collapse">
                            <thead>
                                <tr style="background:#f8fafc">
                                    <th style="text-align:left;padding:10px;border-bottom:1px solid #e5eef7">Name</th>
                                    <th style="text-align:left;padding:10px;border-bottom:1px solid #e5eef7">Display Name</th>
                                    <th style="text-align:left;padding:10px;border-bottom:1px solid #e5eef7">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($roles as $role)
                                    <tr>
                                        <form method="POST" action="{{ route('admin.roles.update', $role) }}">
                                            @csrf
                                            @method('PUT')
                                            <td style="padding:10px;border-bottom:1px solid #e5eef7">
                                                <input type="text" name="name" value="{{ $role->name }}" style="width:100%;padding:8px;border:1px solid #e5eef7;border-radius:8px">
                                            </td>
                                            <td style="padding:10px;border-bottom:1px solid #e5eef7">
                                                <input type="text" name="display_name" value="{{ $role->display_name }}" style="width:100%;padding:8px;border:1px solid #e5eef7;border-radius:8px">
                                            </td>
                                            <td style="padding:10px;border-bottom:1px solid #e5eef7">
                                                <button type="submit" style="background:#0B2C74;color:#fff;border:none;padding:8px 12px;border-radius:8px;cursor:pointer">Save</button>
                                                <form method="POST" action="{{ route('admin.roles.destroy', $role) }}" style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" style="background:#dc2626;color:#fff;border:none;padding:8px 12px;border-radius:8px;cursor:pointer" onclick="return confirm('Delete this role?')">Delete</button>
                                                </form>
                                            </td>
                                        </form>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" style="padding:12px;text-align:center;color:#64748b">No roles found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
