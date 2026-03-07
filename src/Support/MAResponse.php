<?php

declare(strict_types=1);

namespace Agencetwogether\MatomoAnalytics\Support;

use Agencetwogether\MatomoAnalytics\MatomoAnalytics;
use BernskioldMedia\LaravelMatomo\Facades\Matomo;
use Facades\Agencetwogether\MatomoAnalytics\Support\MADataLookups;
use Illuminate\Support\Arr;

final class MAResponse
{
    /**
     * Common method to handle the response data for:
     *  - Page Views
     *  - Visitors
     *  - Visits
     *  - Visits Duration
     *
     * @param  array<string, array<string, int>>  $dataLookup
     */
    public static function common(array $dataLookup, ?string $filter = null): MatomoAnalytics
    {
        $filter ??= 'today';

        $data = Arr::get(
            $dataLookup,
            $filter,
            [
                'result' => 0,
                'previous' => 0,
            ],
        );

        $result = is_numeric($data['result'] ?? null) ? (float) $data['result'] : 0;

        return MatomoAnalytics::for($result)
            ->previous((int) $data['previous'])
            ->format('%');
    }
}
