@extends('layouts.app')

@section('title', 'Short URLs')

@section('content')
<div class="card">
    <div class="header-row">
        <h2>Short URLs</h2>
        @if(!auth()->user()->isSuperAdmin())
            <a href="{{ route('short-urls.create') }}" class="btn">+ Create New</a>
        @endif
    </div>

    @if($shortUrls->isEmpty())
        <p class="empty-msg">No short URLs yet.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Short URL</th>
                    <th>Original URL</th>
                    @if(auth()->user()->isSuperAdmin())
                        <th>Company</th>
                        <th>Created By</th>
                    @elseif(auth()->user()->isAdmin())
                        <th>Created By</th>
                    @endif
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($shortUrls as $url)
                <tr>
                    <td><a href="{{ url('/' . $url->short_code) }}" target="_blank">{{ url('/' . $url->short_code) }}</a></td>
                    <td>{{ $url->original_url }}</td>
                    @if(auth()->user()->isSuperAdmin())
                        <td>{{ $url->company->name }}</td>
                        <td>{{ $url->creator->name }}</td>
                    @elseif(auth()->user()->isAdmin())
                        <td>{{ $url->creator->name }}</td>
                    @endif
                    <td>{{ $url->created_at->format('Y-m-d H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
