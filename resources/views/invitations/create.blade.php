@extends('layouts.app')

@section('title', 'Send Invitation')

@section('content')
<div class="card">
    <h2>Send Invitation</h2>
    <form method="POST" action="{{ route('invitations.store') }}">
        @csrf
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="invite@example.com">
        </div>

        @if(auth()->user()->isSuperAdmin())
            <input type="hidden" name="role" value="admin">
            <div class="form-group">
                <label for="company_name">New Company Name</label>
                <input type="text" id="company_name" name="company_name" value="{{ old('company_name') }}" required placeholder="Company name">
            </div>
        @else
            <div class="form-group">
                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="">Select role</option>
                    <option value="admin"  {{ old('role') === 'admin'  ? 'selected' : '' }}>Admin</option>
                    <option value="member" {{ old('role') === 'member' ? 'selected' : '' }}>Member</option>
                </select>
            </div>
        @endif

        <button type="submit" class="btn">Send Invitation</button>
    </form>
</div>
@endsection
