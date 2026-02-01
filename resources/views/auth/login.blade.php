@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="login-wrap">
    <div class="card">
        <h2>🔗 URL Shortener</h2>
        <p style="color:#888; margin-bottom:25px; font-size:14px;">Sign in to your account</p>

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="you@example.com">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="••••••••">
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</div>
@endsection
