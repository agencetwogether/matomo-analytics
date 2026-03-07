<?php

namespace Agencetwogether\MatomoAnalytics\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class MatomoService
{
    public function query(string $method, array $params = [], ?string $filter = null): array
    {
        $cacheKey = $this->cacheKey($method, $params);

        $ttl = $this->getCacheTtl($filter);

        return Cache::remember(
            $cacheKey,
            now()->addMinutes($ttl),
            fn () => $this->request($method, $params)
        );
    }

    protected function request(string $method, array $params): array
    {
        $response = Http::get(config('matomo-analytics.base_url'), [
            'module' => 'API',
            'method' => $method,
            'idSite' => config('matomo-analytics.id_site'),
            'token_auth' => config('matomo-analytics.api_key'),
            'format' => 'JSON',
            ...$params,
        ]);

        return $response->json();
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

        return config("matomo-analytics.cache.filters.$filter")
            ?? config('matomo-analytics.cache.default_ttl', 10);
    }
}
