<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class InvitationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $invitations = Invitation::with(['company', 'inviter'])
            ->when($user->isSuperAdmin(), fn ($q) => $q)
            ->when($user->isAdmin(), fn ($q) => $q->where('company_id', $user->company_id))
            ->latest()
            ->get();

        return view('invitations.index', compact('invitations'));
    }

    public function create(Request $request)
    {
        return view('invitations.create');
    }

    public function store(Request $request)
    {
        $user = $request->user();
        if ($user->isSuperAdmin()) {
            $request->validate([
                'email'        => ['required', 'email', 'unique:users,email', 'unique:invitations,email'],
                'company_name' => ['required', 'string', 'max:255'],
            ]);

            $company = Company::create(['name' => $request->company_name]);

            Invitation::create([
                'email'       => $request->email,
                'role'        => 'admin',
                'company_id'  => $company->id,
                'invited_by'  => $user->id,
                'token'       => Invitation::generateToken(),
            ]);

            return redirect()->route('invitations.index')
                ->with('success', 'Invitation sent successfully.');
        }
        if ($user->isAdmin()) {
            $request->validate([
                'email' => ['required', 'email', 'unique:users,email', 'unique:invitations,email'],
                'role'  => ['required', Rule::in(['admin', 'member'])],
            ]);

            Invitation::create([
                'email'       => $request->email,
                'role'        => $request->role,
                'company_id'  => $user->company_id,
                'invited_by'  => $user->id,
                'token'       => Invitation::generateToken(),
            ]);

            return redirect()->route('invitations.index')
                ->with('success', 'Invitation sent successfully.');
        }

        abort(403);
    }

    public function accept(string $token)
    {
        $invitation = Invitation::with('company')
            ->where('token', $token)
            ->whereNull('accepted_at')
            ->firstOrFail();

        return view('invitations.accept', compact('invitation'));
    }

    public function acceptStore(Request $request, string $token)
    {
        $invitation = Invitation::where('token', $token)
            ->whereNull('accepted_at')
            ->firstOrFail();

        $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'password'              => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required'],
        ]);

        $user = User::create([
            'name'       => $request->name,
            'email'      => $invitation->email,
            'password'   => Hash::make($request->password),
            'role'       => $invitation->role,
            'company_id' => $invitation->company_id,
        ]);

        $invitation->update(['accepted_at' => now()]);

        auth()->login($user);

        return redirect()->route('dashboard');
    }
}
