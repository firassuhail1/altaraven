<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BandInfo extends Model
{
    protected $table = 'band_info';

    protected $fillable = [
        'band_name', 'tagline', 'history', 'description',
        'founded_year', 'genre', 'origin',
        'hero_image', 'hero_video', 'social_links', 'email',
    ];

    protected $casts = [
        'social_links' => 'array',
    ];

    public static function getInstance(): self
    {
        return self::firstOrCreate(
            ['id' => 1],
            ['band_name' => 'ALTARAVEN']
        );
    }
}
