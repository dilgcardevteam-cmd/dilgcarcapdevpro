<div class="users-table-shell">
    <div class="users-table-wrap">
        <table class="users-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Account ID</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Location</th>
                    <th>Joined Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    @php
                        $location = trim(($user->city ?? '') . (($user->city && $user->province) ? ', ' : '') . ($user->province ?? ''));
                        $roleMap = isset($roleDisplay) && is_array($roleDisplay) ? $roleDisplay : [];
                        $rawRole = $user->role;
                        $roleClass = in_array($rawRole, ['super_admin','admin','registrar','training_manager','coach','trainer','trainee','participant']) ? ($rawRole === 'trainer' ? 'coach' : $rawRole) : 'trainee';
                        $roleLabel = $roleMap[$rawRole] ?? ($rawRole === 'trainer' ? 'Coach' : ($rawRole === 'training_manager' ? 'Training Manager' : ucfirst(str_replace('_',' ',$rawRole))));
                        $statusValue = $user->status ?? 'active';
                        $statusClass = in_array($statusValue, ['active', 'freeze', 'pending']) ? $statusValue : 'active';
                        $statusLabel = $statusValue === 'freeze' ? 'Blocked' : $statusValue;
                    @endphp
                    <tr @if($user->id === auth()->id()) style="background-color: #f8fafc; border-left: 4px solid #002C76;" @endif>
                        <td>
                            <div class="user-identity">
                                <span class="user-avatar" @if($user->id === auth()->id()) style="background-color: #002C76; border: 2px solid #ffffff;" @endif>{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</span>
                                <span class="user-name">
                                    {{ $user->name }}
                                    @if($user->id === auth()->id())
                                        <span style="font-size: 0.75rem; color: #002C76; font-weight: 800; background: #eef2ff; padding: 2px 6px; border-radius: 4px; margin-left: 4px;">You</span>
                                    @endif
                                </span>
                            </div>
                        </td>
                        <td><span class="mono-text">{{ $user->status === 'pending' ? '-' : ($user->account_id ?? '-') }}</span></td>
                        <td>{{ $user->email }}</td>
                        <td><span class="badge-pill badge-role-{{ $roleClass }}">{{ $roleLabel }}</span></td>
                        <td class="muted-cell">{{ $location !== '' ? $location : 'Not set' }}</td>
                        <td class="muted-cell">{{ $user->created_at->setTimezone(config('app.timezone'))->format('M d, Y h:ia') }}</td>
                        <td><span class="badge-pill badge-status-{{ $statusClass }}">{{ $statusLabel }}</span></td>
                        <td>
                            <div class="actions-inline">
                                <button type="button" onclick='openEditModal(@json($user))' class="btn-table-action btn-action-manage">
                                    <i class="fas fa-cog"></i>
                                    Manage
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="table-empty">
                            <i class="fas fa-users-slash"></i>
                            No users found for the current filters.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="users-page-number">
    Page {{ $users->currentPage() }} of {{ $users->lastPage() }}
</div>

<div class="users-pagination">
    {{ $users->withQueryString()->links() }}
</div>
