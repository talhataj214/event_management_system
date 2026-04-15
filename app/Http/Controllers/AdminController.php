<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $totalUsers = User::count();
        $totalEvents = Event::count();
        $totalBookings = Booking::count();
        $users = User::latest()->get();

        return view('dashboard', compact(
            'totalUsers',
            'totalEvents',
            'totalBookings',
            'users'
        ));
    }

    public function updateUserRole(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'role' => ['required', 'in:admin,user'],
        ]);

        $user = User::findOrFail($id);

        if ($user->id === auth()->id() && $request->role !== 'admin') {
            return redirect()
                ->route('admin.dashboard')
                ->with('error', 'You cannot remove your own admin role.');
        }

        $user->update([
            'role' => $request->role,
        ]);

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'User role updated successfully.');
    }
}