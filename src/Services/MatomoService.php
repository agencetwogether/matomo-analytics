<?php

namespace Agencetwogether\MatomoAnalytics\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class MatomoService
{
    public function query(string $method, array $params = [], ?string $filter = null): array
    {
        $cacheKey = $this->cacheKey($method, $params);
        $fallbackKey = $cacheKey . '.fallback';

        $ttl = $this->getCacheTtl($filter);

        return Cache::remember(
            $cacheKey,
            now()->addMinutes($ttl),
            function () use ($method, $params, $fallbackKey) {
                try {

                    $data = $this->request($method, $params);

                    Cache::forget('matomo_api_down');
                    Cache::put('matomo_last_success', now(), now()->addDay());

                    // Fallback
                    Cache::put($fallbackKey, $data, now()->addHours(2));

                    return $data;

                } catch (\Throwable $e) {

                    $minTtl = collect(config('matomo-analytics.cache.ttl'))->min();
                    // API DOWN
                    Cache::put(
                        'matomo_api_down',
                        [
                            'isDown' => true,
                            'nextCall' => now()->addMinutes($minTtl),
                        ],
                        now()->addMinutes($minTtl)
                    );

                    // Fallback
                    return Cache::get($fallbackKey, []);
                }
            }
        );
    }

    protected function request(string $method, array $params): array
    {
        $response = Http::timeout(5)
            ->connectTimeout(2)
            ->get(config('matomo-analytics.base_url'), [
                'module' => 'API',
                'method' => $method,
                'idSite' => (int) config('matomo-analytics.id_site'),
                'token_auth' => config('matomo-analytics.api_key'),
                'format' => 'JSON',
                'language' => config('app.locale', 'en'),
                ...$params,
            ])
            ->throw();

        return $response->json() ?? [];
    }

    protected function cacheKey(string $method, array $params): string
    {
        return 'matomo.' . $method . '.' . md5(json_encode($params));
    }

    protected function getCacheTtl(?string $filter): int
    {
        if (! config('matomo-analytics.cache.enabled')) {
            return 0;
        }

        return config("matomo-analytics.cache.ttl.$filter")
            ?? config('matomo-analytics.cache.default_ttl', 10);
    }
}
