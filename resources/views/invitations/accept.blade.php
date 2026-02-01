@extends('layouts.app')

@section('title', 'Accept Invitation')

@section('content')
<div style="max-width:500px; margin:0 auto;">
    <div class="card">
        <h2>Accept Invitation</h2>
        <div class="info-box" style="margin-bottom:25px;">
            <p>Company: <strong>{{ $invitation->company->name }}</strong></p>
            <p>Role: <strong>{{ $invitation->role->label() }}</strong></p>
            <p>Email: <strong>{{ $invitation->email }}</strong></p>
        </div>

        <form method="POST" action="{{ route('invite.accept.store', $invitation->token) }}">
            @csrf
            <div class="form-group">
                <label for="name">Your Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="John Doe" style="max-width:100%;">
            </div>
            <div class="form-group">
                <label for="password">Password (min 8 characters)</label>
                <input type="password" id="password" name="password" required placeholder="••••••••" style="max-width:100%;">
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="••••••••" style="max-width:100%;">
            </div>
            <button type="submit" class="btn" style="width:100%; padding:11px;">Create Account</button>
        </form>
    </div>
</div>
@endsection
