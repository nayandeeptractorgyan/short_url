@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="card">
    <h2>Dashboard</h2>
    <div class="info-box">
        <p>Welcome, <strong>{{ $user->name }}</strong></p>
        <p>Role: <strong>{{ $user->role->label() }}</strong></p>
        @if($user->company)
            <p>Company: <strong>{{ $user->company->name }}</strong></p>
        @endif
    </div>
</div>
@endsection
