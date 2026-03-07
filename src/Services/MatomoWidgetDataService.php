<?php

namespace Agencetwogether\MatomoAnalytics\Services;

use Agencetwogether\MatomoAnalytics\Support\MatomoDateResolver;

class MatomoWidgetDataService
{
    public function __construct(private readonly MatomoService $matomo) {}

    public function get(string $method, string $filter, bool $hasPeriod = true): array
    {
        $params = MatomoDateResolver::resolve($filter, $hasPeriod);

        return $this->matomo->query($method, $params, $filter);
    }
}
