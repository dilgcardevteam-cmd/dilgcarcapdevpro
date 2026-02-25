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
                                <button type="button" onclick='openViewModal(@json($user))' class="btn-table-action btn-action-view btn-icon-only" title="Update user" aria-label="Update user">
                                    <svg class="icon-feather" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M12 20h9"></path>
                                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"></path>
                                    </svg>
                                </button>
                                <form action="{{ route('users.delete', $user->id) }}" method="POST" onsubmit="return confirm('Delete this user? This action cannot be undone.')" class="inline-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-table-action btn-action-danger btn-icon-only" title="Delete user" aria-label="Delete user">
                                        <svg class="icon-feather" viewBox="0 0 24 24" aria-hidden="true">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path>
                                            <path d="M10 11v6"></path>
                                            <path d="M14 11v6"></path>
                                            <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"></path>
                                        </svg>
                                    </button>
                                </form>
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
