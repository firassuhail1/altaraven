<?php

namespace Database\Seeders;

use App\Models\BandInfo;
use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin user ────────────────────────────────────────────────────────
        User::firstOrCreate(
            ['email' => 'admin@altaraven.com'],
            [
                'name'              => 'Admin ALTARAVEN',
                'password'          => Hash::make('altaraven123'),
                'email_verified_at' => now(),
            ]
        );

        // ── Band info ─────────────────────────────────────────────────────────
        BandInfo::updateOrCreate(['id' => 1], [
            'band_name'    => 'ALTARAVEN',
            'tagline'      => 'We don\'t play music. We wage war.',
            'description'  => 'ALTARAVEN is a metal band from Indonesia, forging heavy sounds that cut through silence and leave no room for the mundane.',
            'history'      => "Born from the underground, ALTARAVEN formed in 2018 with a singular mission: to create music that is as uncompromising as it is powerful.\n\nDrawing inspiration from the darkest corners of metal — from the crushing weight of doom to the precision of progressive — the band has carved their own identity in the scene.\n\nAfter years of relentless gigging and honing their craft, they emerged with a sound that is distinctly their own: heavy, melodic, and unapologetically dark.",
            'founded_year' => '2018',
            'genre'        => 'Metal',
            'origin'       => 'Jakarta, Indonesia',
            'email'        => 'info@altaraven.com',
            'social_links' => [
                'instagram' => 'https://instagram.com/altaraven',
                'spotify'   => 'https://open.spotify.com/artist/altaraven',
                'youtube'   => 'https://youtube.com/@altaraven',
                'facebook'  => null,
                'tiktok'    => null,
            ],
        ]);

        // ── Members ───────────────────────────────────────────────────────────
        $members = [
            ['name' => 'Raven',  'role' => 'Vocals',  'order' => 1, 'bio' => 'The voice of ALTARAVEN. Raw, powerful, and relentless.'],
            ['name' => 'Altar',  'role' => 'Guitar',  'order' => 2, 'bio' => 'Riff architect. Writes the soundtrack to your darkest nights.'],
            ['name' => 'Shadow', 'role' => 'Guitar',  'order' => 3, 'bio' => 'Lead guitar and melody. The light in the darkness.'],
            ['name' => 'Abyss',  'role' => 'Bass',    'order' => 4, 'bio' => 'The low-end foundation that shakes the earth.'],
            ['name' => 'Storm',  'role' => 'Drums',   'order' => 5, 'bio' => 'The engine of ALTARAVEN. Precision and power in equal measure.'],
        ];

        foreach ($members as $m) {
            Member::firstOrCreate(['name' => $m['name']], array_merge($m, ['is_active' => true]));
        }
    }
}
