<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\Request;

class ShortUrlController extends Controller
{
    // List short URLs filtered by role
    public function index(Request $request)
    {
        $user = $request->user();

        $shortUrls = match (true) {
            // SuperAdmin sees ALL short URLs across every company
            $user->isSuperAdmin() => ShortUrl::with(['company', 'creator'])->latest()->get(),
            $user->isAdmin() => ShortUrl::with(['creator'])
                ->where('company_id', $user->company_id)
                ->latest()->get(),
            default => ShortUrl::where('created_by', $user->id)->latest()->get(),
        };

        return view('short-urls.index', compact('shortUrls'));
    }

    public function create(Request $request)
    {
        if ($request->user()->isSuperAdmin()) {
            abort(403);
        }

        return view('short-urls.create');
    }

    
    public function store(Request $request)
    {
        $user = $request->user();

        // SuperAdmin cannot create
        if ($user->isSuperAdmin()) {
            abort(403);
        }

        $request->validate([
            'original_url' => ['required', 'url:http,https', 'max:2048'],
        ]);

        ShortUrl::create([
            'original_url' => $request->original_url,
            'short_code'   => ShortUrl::generateShortCode(),
            'company_id'   => $user->company_id,
            'created_by'   => $user->id,
        ]);

        return redirect()->route('short-urls.index')
            ->with('success', 'Short URL created successfully.');
    }

   
    public function redirect(string $shortCode)
    {
        $shortUrl = ShortUrl::where('short_code', $shortCode)->firstOrFail();

        return redirect($shortUrl->original_url);
    }
}
