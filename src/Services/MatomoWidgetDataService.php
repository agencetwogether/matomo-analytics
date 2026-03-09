<?php

namespace Agencetwogether\MatomoAnalytics\Services;

use Agencetwogether\MatomoAnalytics\Support\MatomoDateResolver;

class MatomoWidgetDataService
{
    public function __construct(private readonly MatomoService $matomo) {}

    public function get(string $method, string $filter, bool $hasPreviousPeriod = true): array
    {
        $params = MatomoDateResolver::resolve($filter, $hasPreviousPeriod);

        return $this->matomo->query($method, $params, $filter);
    }
}
