<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ShortUrl extends Model
{
    use HasFactory;

    protected $fillable = [
        'original_url',
        'short_code',
        'company_id',
        'created_by',
    ];

    public function company(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function creator(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public static function generateShortCode(): string
    {
        do {
            $code = Str::random(6);
        } while (self::where('short_code', $code)->exists());

        return $code;
    }
}
