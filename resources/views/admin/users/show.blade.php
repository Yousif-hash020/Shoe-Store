@extends('admin.layouts.app')

@section('title', 'View User')
@section('page-title', 'User Details: ' . $user->name)

@section('content')
<!-- Action Buttons -->
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Users
            </a>
            <div class="btn-group" role="group">
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-admin-warning">
                    <i class="fas fa-edit me-2"></i>Edit User
                </a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-user me-2"></i>User Information
                </h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Full Name:</strong>
                        <p class="mb-0">{{ $user->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Email Address:</strong>
                        <p class="mb-0">
                            {{ $user->email }}
                            @if($user->email_verified_at)
                                <i class="fas fa-check-circle text-success ms-1" title="Verified"></i>
                            @else
                                <i class="fas fa-exclamation-circle text-warning ms-1" title="Not Verified"></i>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Phone Number:</strong>
                        <p class="mb-0">{{ $user->phone ?? 'Not provided' }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Date of Birth:</strong>
                        <p class="mb-0">{{ $user->date_of_birth ? $user->date_of_birth->format('M d, Y') : 'Not provided' }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Gender:</strong>
                        <p class="mb-0">{{ $user->gender ? ucfirst(str_replace('_', ' ', $user->gender)) : 'Not specified' }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Admin Status:</strong>
                        <p class="mb-0">
                            @if($user->is_admin)
                                <span class="badge bg-warning">Administrator</span>
                            @else
                                <span class="badge bg-secondary">Regular User</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Status -->
        <div class="admin-card mt-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Account Status
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Account Status:</strong>
                        <p class="mb-0">
                            @if($user->email_verified_at)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-warning">Unverified</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <strong>Email Verified:</strong>
                        <p class="mb-0">
                            @if($user->email_verified_at)
                                <span class="text-success">Yes - {{ $user->email_verified_at->format('M d, Y \a\t g:i A') }}</span>
                            @else
                                <span class="text-warning">No</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Account Information -->
        <div class="admin-card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-calendar me-2"></i>Account Details
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>User ID:</strong>
                    <p class="mb-0">{{ $user->id }}</p>
                </div>
                <div class="mb-3">
                    <strong>Member Since:</strong>
                    <p class="mb-0">{{ $user->created_at->format('M d, Y') }}</p>
                    <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                </div>
                <div class="mb-3">
                    <strong>Last Updated:</strong>
                    <p class="mb-0">{{ $user->updated_at->format('M d, Y') }}</p>
                    <small class="text-muted">{{ $user->updated_at->diffForHumans() }}</small>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="admin-card mt-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-cogs me-2"></i>Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Edit User
                    </a>

                    @if($user->id !== auth()->id())
                        @if(!$user->email_verified_at)
                            <form action="{{ route('admin.users.verify', $user) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-check me-2"></i>Verify Email
                                </button>
                            </form>
                        @endif

                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-trash me-2"></i>Delete User
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="row mt-4">
    <div class="col-12">
        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Users
            </a>
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-admin-success">
                <i class="fas fa-edit me-2"></i>Edit User
            </a>
        </div>
    </div>
</div>

<!-- Delete Modal -->
@if($user->id !== auth()->id())
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong>{{ $user->name }}</strong>?</p>
                <p class="text-danger small">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete User</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
