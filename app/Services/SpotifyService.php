<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class SpotifyService
{
    private string $clientId;
    private string $clientSecret;
    private string $baseUrl = 'https://api.spotify.com/v1';

    public function __construct()
    {
        $this->clientId     = config('services.spotify.client_id');
        $this->clientSecret = config('services.spotify.client_secret');
    }

    // ─── Auth ───────────────────────────────────────────────────────────────

    private function getAccessToken(): string
    {
        return Cache::remember('spotify_access_token', 3500, function () {
            $response = Http::asForm()->withBasicAuth($this->clientId, $this->clientSecret)
                ->post('https://accounts.spotify.com/api/token', [
                    'grant_type' => 'client_credentials',
                ]);

            if ($response->failed()) {
                throw new \Exception('Spotify auth failed: ' . $response->body());
            }

            return $response->json('access_token');
        });
    }

    private function get(string $endpoint, array $params = []): array
    {
        $response = Http::withToken($this->getAccessToken())
            ->get("{$this->baseUrl}/{$endpoint}", $params);

        if ($response->status() === 401) {
            Cache::forget('spotify_access_token');
            $response = Http::withToken($this->getAccessToken())
                ->get("{$this->baseUrl}/{$endpoint}", $params);
        }

        return $response->json() ?? [];
    }

    // ─── Search ─────────────────────────────────────────────────────────────

    public function searchTracks(string $query, int $limit = 10): array
    {
        return Cache::remember("spotify_search_tracks_{$query}_{$limit}", 300, function () use ($query, $limit) {
            $data = $this->get('search', ['q' => $query, 'type' => 'track', 'limit' => $limit]);
            return $data['tracks']['items'] ?? [];
        });
    }

    public function searchAlbums(string $query, int $limit = 10): array
    {
        return Cache::remember("spotify_search_albums_{$query}_{$limit}", 300, function () use ($query, $limit) {
            $data = $this->get('search', ['q' => $query, 'type' => 'album', 'limit' => $limit]);
            return $data['albums']['items'] ?? [];
        });
    }

    // ─── Fetch by ID ─────────────────────────────────────────────────────────

    public function getTrack(string $id): array
    {
        return Cache::remember("spotify_track_{$id}", 3600, function () use ($id) {
            return $this->get("tracks/{$id}");
        });
    }

    public function getAlbum(string $id): array
    {
        return Cache::remember("spotify_album_{$id}", 3600, function () use ($id) {
            return $this->get("albums/{$id}");
        });
    }

    public function getAlbumTracks(string $albumId): array
    {
        return Cache::remember("spotify_album_tracks_{$albumId}", 3600, function () use ($albumId) {
            $data = $this->get("albums/{$albumId}/tracks", ['limit' => 50]);
            return $data['items'] ?? [];
        });
    }

    // ─── Artist ───────────────────────────────────────────────────────────

    public function getArtist(string $id): array
    {
        return Cache::remember("spotify_artist_{$id}", 3600, function () use ($id) {
            return $this->get("artists/{$id}");
        });
    }

    public function getArtistAlbums(string $artistId, int $limit = 20): array
    {
        return Cache::remember("spotify_artist_albums_{$artistId}", 3600, function () use ($artistId, $limit) {
            $data = $this->get("artists/{$artistId}/albums", [
                'include_groups' => 'album,single,ep',
                'limit' => $limit,
            ]);
            return $data['items'] ?? [];
        });
    }

    // ─── Embed helpers ───────────────────────────────────────────────────────

    public static function embedTrackUrl(string $trackId): string
    {
        return "https://open.spotify.com/embed/track/{$trackId}?utm_source=generator&theme=0";
    }

    public static function embedAlbumUrl(string $albumId): string
    {
        return "https://open.spotify.com/embed/album/{$albumId}?utm_source=generator&theme=0";
    }

    public static function formatDuration(int $ms): string
    {
        $seconds = intdiv($ms, 1000);
        return sprintf('%d:%02d', intdiv($seconds, 60), $seconds % 60);
    }
}
