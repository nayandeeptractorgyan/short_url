@extends('layouts.app')

@section('title', 'Invitations')

@section('content')
<div class="card">
    <div class="header-row">
        <h2>Invitations</h2>
        <a href="{{ route('invitations.create') }}" class="btn">+ Send Invitation</a>
    </div>

    @if($invitations->isEmpty())
        <p class="empty-msg">No invitations yet.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Company</th>
                    <th>Invited By</th>
                    <th>Status</th>
                    <th>Invite Link</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invitations as $inv)
                <tr>
                    <td>{{ $inv->email }}</td>
                    <td>{{ $inv->role->label() }}</td>
                    <td>{{ $inv->company->name }}</td>
                    <td>{{ $inv->inviter->name }}</td>
                    <td>
                        @if($inv->isAccepted())
                            <span class="status-accepted">Accepted</span>
                        @else
                            <span class="status-pending">Pending</span>
                        @endif
                    </td>
                    <td>
                        @if(!$inv->isAccepted())
                            <a href="{{ route('invite.accept', $inv->token) }}" target="_blank">Copy Link</a>
                        @else
                            —
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
