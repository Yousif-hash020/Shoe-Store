<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Advanced search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->filled('role')) {
            $role = $request->get('role');
            if ($role === 'admin') {
                $query->where('is_admin', true);
            } elseif ($role === 'user') {
                $query->where('is_admin', false);
            }
        }

        // Filter by status
        if ($request->filled('status')) {
            $status = $request->get('status');
            if ($status === 'verified') {
                $query->whereNotNull('email_verified_at');
            } elseif ($status === 'unverified') {
                $query->whereNull('email_verified_at');
            }
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->get('date_from'));
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->get('date_to'));
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $users = $query->paginate(15)->withQueryString();

        // Statistics
        $stats = [
            'total' => User::count(),
            'verified' => User::whereNotNull('email_verified_at')->count(),
            'admins' => User::where('is_admin', true)->count(),
            'recent' => User::where('created_at', '>=', Carbon::now()->subDays(7))->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
                'phone' => ['nullable', 'string', 'regex:/^\+?[1-9]\d{1,14}$/'],
                'date_of_birth' => ['nullable', 'date', 'before:today'],
                'gender' => ['nullable', 'in:male,female,other,prefer_not_to_say'],
                'address' => ['nullable', 'string', 'max:500'],
                'city' => ['nullable', 'string', 'max:100'],
                'country' => ['nullable', 'string', 'max:100'],
                'is_admin' => ['boolean'],
                'is_active' => ['boolean'],
                'send_welcome_email' => ['boolean'],
            ], [
                'name.regex' => 'Name should only contain letters and spaces.',
                'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, and one number.',
                'phone.regex' => 'Please enter a valid phone number.',
                'date_of_birth.before' => 'Date of birth must be in the past.',
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'phone' => $validated['phone'] ?? null,
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'gender' => $validated['gender'] ?? null,
                'address' => $validated['address'] ?? null,
                'city' => $validated['city'] ?? null,
                'country' => $validated['country'] ?? null,
                'is_admin' => $request->boolean('is_admin', false),
                'is_active' => $request->boolean('is_active', true),
                'email_verified_at' => now(),
                'created_by' => auth()->id(),
            ]);

            DB::commit();

            Log::info('User created successfully', [
                'user_id' => $user->id,
                'email' => $user->email,
                'created_by' => auth()->user()->email
            ]);

            $message = 'User created successfully!';
            if ($request->boolean('send_welcome_email')) {
                // Here you would send welcome email
                $message .= ' Welcome email sent.';
            }

            return redirect()->route('admin.users.index')->with('success', $message);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::error('User creation validation failed', ['errors' => $e->errors()]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('User creation failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to create user: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load(['createdBy', 'updatedBy']);

        // User activity stats
        $stats = [
            'account_age' => $user->created_at->diffForHumans(),
            'last_login' => $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never',
            'total_orders' => 0, // You can implement this based on your orders table
            'status' => $user->email_verified_at ? 'Verified' : 'Unverified',
        ];

        return view('admin.users.show', compact('user', 'stats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'password' => ['nullable', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
                'phone' => ['nullable', 'string', 'regex:/^\+?[1-9]\d{1,14}$/'],
                'date_of_birth' => ['nullable', 'date', 'before:today'],
                'gender' => ['nullable', 'in:male,female,other,prefer_not_to_say'],
                'address' => ['nullable', 'string', 'max:500'],
                'city' => ['nullable', 'string', 'max:100'],
                'country' => ['nullable', 'string', 'max:100'],
                'is_admin' => ['boolean'],
                'is_active' => ['boolean'],
            ], [
                'name.regex' => 'Name should only contain letters and spaces.',
                'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, and one number.',
                'phone.regex' => 'Please enter a valid phone number.',
                'date_of_birth.before' => 'Date of birth must be in the past.',
            ]);

            $data = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'gender' => $validated['gender'] ?? null,
                'address' => $validated['address'] ?? null,
                'city' => $validated['city'] ?? null,
                'country' => $validated['country'] ?? null,
                'is_active' => $request->boolean('is_active', true),
                'updated_by' => auth()->id(),
            ];

            // Only update is_admin if not editing own account
            if ($user->id !== auth()->id()) {
                $data['is_admin'] = $request->boolean('is_admin', false);
            }

            // Only update password if provided
            if ($request->filled('password')) {
                $data['password'] = Hash::make($validated['password']);
            }

            $user->update($data);

            DB::commit();

            Log::info('User updated successfully', [
                'user_id' => $user->id,
                'email' => $user->email,
                'updated_by' => auth()->user()->email
            ]);

            return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::error('User update validation failed', ['errors' => $e->errors()]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('User update failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to update user: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            // Prevent deleting the currently authenticated admin
            if ($user->id === auth()->id()) {
                return redirect()->route('admin.users.index')->with('error', 'You cannot delete your own account!');
            }

            // Prevent deleting super admin if exists
            if ($user->email === 'admin@elitekicks.com' && $user->is_admin) {
                return redirect()->route('admin.users.index')->with('error', 'Cannot delete the super admin account!');
            }

            DB::beginTransaction();

            $userName = $user->name;
            $userEmail = $user->email;

            $user->delete();

            DB::commit();

            Log::info('User deleted successfully', [
                'user_name' => $userName,
                'user_email' => $userEmail,
                'deleted_by' => auth()->user()->email
            ]);

            return redirect()->route('admin.users.index')->with('success', "User '{$userName}' deleted successfully!");

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('User deletion failed', ['error' => $e->getMessage()]);
            return redirect()->route('admin.users.index')->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }

    /**
     * Toggle user's active status
     */
    public function toggleStatus(User $user)
    {
        try {
            if ($user->id === auth()->id()) {
                return response()->json(['error' => 'You cannot change your own status!'], 400);
            }

            $user->update(['is_active' => !$user->is_active]);

            $status = $user->is_active ? 'activated' : 'deactivated';

            Log::info("User {$status}", [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'changed_by' => auth()->user()->email
            ]);

            return response()->json([
                'success' => true,
                'message' => "User {$status} successfully!",
                'status' => $user->is_active
            ]);

        } catch (\Exception $e) {
            Log::error('Status toggle failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to change user status'], 500);
        }
    }

    /**
     * Verify user's email
     */
    public function verify(User $user)
    {
        if ($user->email_verified_at) {
            return redirect()->back()->with('info', 'User email is already verified.');
        }

        $user->update(['email_verified_at' => now()]);

        Log::info('User email verified', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'verified_by' => auth()->user()->email
        ]);

        return redirect()->back()->with('success', 'User email verified successfully!');
    }

    /**
     * Bulk actions for users
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => ['required', 'in:delete,activate,deactivate,verify'],
            'users' => ['required', 'array', 'min:1'],
            'users.*' => ['exists:users,id'],
        ]);

        try {
            DB::beginTransaction();

            $userIds = $request->users;
            $action = $request->action;

            // Prevent bulk actions on own account
            if (in_array(auth()->id(), $userIds)) {
                return redirect()->back()->with('error', 'You cannot perform bulk actions on your own account!');
            }

            $users = User::whereIn('id', $userIds)->get();
            $count = $users->count();

            switch ($action) {
                case 'delete':
                    User::whereIn('id', $userIds)->delete();
                    $message = "{$count} users deleted successfully!";
                    break;

                case 'activate':
                    User::whereIn('id', $userIds)->update(['is_active' => true]);
                    $message = "{$count} users activated successfully!";
                    break;

                case 'deactivate':
                    User::whereIn('id', $userIds)->update(['is_active' => false]);
                    $message = "{$count} users deactivated successfully!";
                    break;

                case 'verify':
                    User::whereIn('id', $userIds)->whereNull('email_verified_at')->update(['email_verified_at' => now()]);
                    $message = "{$count} users verified successfully!";
                    break;
            }

            DB::commit();

            Log::info("Bulk action performed", [
                'action' => $action,
                'user_count' => $count,
                'performed_by' => auth()->user()->email
            ]);

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Bulk action failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Bulk action failed: ' . $e->getMessage());
        }
    }

    /**
     * Export users data
     */
    public function export(Request $request)
    {
        $format = $request->get('format', 'csv');

        $users = User::select('id', 'name', 'email', 'phone', 'created_at', 'email_verified_at', 'is_admin', 'is_active')->get();

        if ($format === 'csv') {
            $filename = 'users_' . date('Y-m-d_H-i-s') . '.csv';

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            ];

            $callback = function() use ($users) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['ID', 'Name', 'Email', 'Phone', 'Created At', 'Email Verified', 'Is Admin', 'Is Active']);

                foreach ($users as $user) {
                    fputcsv($file, [
                        $user->id,
                        $user->name,
                        $user->email,
                        $user->phone ?? 'N/A',
                        $user->created_at->format('Y-m-d H:i:s'),
                        $user->email_verified_at ? 'Yes' : 'No',
                        $user->is_admin ? 'Yes' : 'No',
                        $user->is_active ? 'Active' : 'Inactive',
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        return redirect()->back()->with('error', 'Invalid export format');
    }
}
