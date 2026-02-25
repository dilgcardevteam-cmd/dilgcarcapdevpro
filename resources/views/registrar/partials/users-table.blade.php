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
                        $roleClass = in_array($user->role, ['admin', 'registrar', 'trainer', 'trainee']) ? $user->role : 'trainee';
                        $statusValue = $user->status ?? 'active';
                        $statusClass = in_array($statusValue, ['active', 'freeze', 'pending']) ? $statusValue : 'active';
                    @endphp
                    <tr>
                        <td>
                            <div class="user-identity">
                                <span class="user-avatar">{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</span>
                                <span class="user-name">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td><span class="mono-text">{{ $user->account_id ?? '-' }}</span></td>
                        <td>{{ $user->email }}</td>
                        <td><span class="badge-pill badge-role-{{ $roleClass }}">{{ $user->role }}</span></td>
                        <td class="muted-cell">{{ $location !== '' ? $location : 'Not set' }}</td>
                        <td class="muted-cell">{{ $user->created_at->setTimezone(config('app.timezone'))->format('M d, Y h:ia') }}</td>
                        <td><span class="badge-pill badge-status-{{ $statusClass }}">{{ $statusValue }}</span></td>
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

<!-- Pagination -->
<div class="users-pagination">
    {{ $users->withQueryString()->links() }}
</div>
