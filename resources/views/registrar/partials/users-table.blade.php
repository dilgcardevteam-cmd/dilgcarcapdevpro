<div class="users-table-shell">
    <div class="users-table-wrap">
        <table class="users-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Account ID</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Field of Work</th>
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
                        $knownRoles = [
                            'super_admin','admin','registrar',
                            'training_manager','coach','trainer','trainee','participant',
                            'central_office_admin','regional_office_admin','provincial_office_admin',
                            'central_office_training_manager','regional_office_training_manager','provincial_office_training_manager',
                            'central_office_coach','regional_office_coach','provincial_office_coach',
                            'central_office_participants','regional_office_participants','provincial_office_participants',
                        ];
                        $roleClass = in_array($rawRole, $knownRoles) ? ($rawRole === 'trainer' ? 'coach' : $rawRole) : 'trainee';
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
                        <td class="muted-cell">{{ $user->field_of_work ?? '-' }}</td>
                        <td class="muted-cell">{{ $location !== '' ? $location : 'Not set' }}</td>
                        <td class="muted-cell">{{ $user->created_at->setTimezone(config('app.timezone'))->format('M d, Y h:ia') }}</td>
                        <td><span class="badge-pill badge-status-{{ $statusClass }}">{{ $statusLabel }}</span></td>
                        <td>
                            @if(auth()->user()->canUpdateUsers())
                                <div class="actions-inline">
                                    <button type="button" onclick='openEditModal(@json($user))' class="btn-table-action btn-action-manage">
                                        <i class="fas fa-cog"></i>
                                        Manage
                                    </button>
                                </div>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="table-empty">
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

<!-- Pagination -->
<div class="users-pagination">
    {{ $users->withQueryString()->links() }}
</div>


