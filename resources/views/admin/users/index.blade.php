@extends('admin.layouts.app')

@section('title', 'Users')
@section('page-title', 'User Management')

@section('content')
    <!-- Action Bar -->
    <div class="row mb-4">
        <div class="col-md-6">
            <a href="{{ route('admin.users.create') }}" class="btn btn-admin-success">
                <i class="fas fa-user-plus me-2"></i>Add New User
            </a>
        </div>
        <div class="col-md-6">
            <form method="GET" action="{{ route('admin.users.index') }}" class="d-flex">
                <input type="text" name="search" class="form-control me-2"
                       placeholder="Search users..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-admin-primary">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Filters -->
    <div class="admin-card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.users.index') }}" class="row g-3">
                <div class="col-md-4">
                    <input type="date" name="date_from" class="form-control"
                           placeholder="From Date" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-4">
                    <input type="date" name="date_to" class="form-control"
                           placeholder="To Date" value="{{ request('date_to') }}">
                </div>
                <div class="col-md-4">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-admin-primary flex-fill">
                            <i class="fas fa-filter me-1"></i>Filter
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <div class="admin-card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-users me-2"></i>Users ({{ $users->total() }})
            </h5>
        </div>
        <div class="card-body">
            @if($users->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Joined</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3"
                                                 style="width: 40px; height: 40px;">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                            <div>
                                                <strong>{{ $user->name }}</strong>
                                                @if($user->is_admin)
                                                    <span class="badge bg-warning ms-2">Admin</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $user->email }}
                                        @if($user->email_verified_at)
                                            <i class="fas fa-check-circle text-success ms-1" title="Verified"></i>
                                        @else
                                            <i class="fas fa-exclamation-circle text-warning ms-1" title="Not Verified"></i>
                                        @endif
                                    </td>
                                    <td>{{ $user->phone ?? 'N/A' }}</td>
                                    <td>
                                        @if($user->email_verified_at)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-warning">Unverified</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $user->created_at->format('M d, Y') }}
                                        <br>
                                        <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.users.show', $user) }}"
                                               class="btn btn-sm btn-admin-primary" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.users.edit', $user) }}"
                                               class="btn btn-sm btn-admin-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>


                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $users->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users text-muted" style="font-size: 4rem;"></i>
                    <h4 class="mt-3 mb-2">No Users Found</h4>
                    <p class="text-muted mb-4">
                        @if(request()->hasAny(['search', 'date_from', 'date_to']))
                            No users match your current filters.
                        @else
                            No users have registered yet.
                        @endif
                    </p>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-admin-success">
                        <i class="fas fa-user-plus me-2"></i>Add First User
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
