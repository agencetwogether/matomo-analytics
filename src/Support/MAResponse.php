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
        $filter ??= 'T';

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

    /**
     * Visits by country data for pie chart widgets
     *
     * @return array<string, int|string>
     */
    public static function visitsByCountry(?string $filter = null): array
    {
        $filter ??= 'T';

        /** @var \Carbon\CarbonPeriod $period */
        $period = MADataLookups::visitsByDeviceAndByCountryAndCity()[$filter];

        $analyticsData = Matomo::geography()->period('range')->date("{$period->start->format('Y-m-d')},{$period->end->format('Y-m-d')}")->site(config('matomo-analytics.id_site'))->countries();

        $results = [];
        foreach ($analyticsData as $key => $analyticData) {
            $results[str($analyticData->label)->studly()->append(' (' . number_format((int) $analyticData->sum_daily_nb_uniq_visitors) . ')')->toString()] = $analyticData->sum_daily_nb_uniq_visitors;
        }

        $total = 0;
        foreach ($results as $result) {
            $total += $result;
        }
        $results = Arr::sortDesc($results);

        $results[__('matomo-analytics::widgets.total') . ' (' . number_format($total) . ')'] = number_format($total);

        return $results;
    }

    /**
     * Visits per hour data for bar chart widgets
     *
     * @return array<string, int|string>
     */
    public static function visitsPerHour(?string $filter = null): array
    {
        $filter ??= 'T';

        /** @var \Carbon\CarbonPeriod $period */
        $period = MADataLookups::visitsPerHour()[$filter];

        $analyticsData = Matomo::durations()->period('range')->date("{$period->start->format('Y-m-d')},{$period->end->format('Y-m-d')}")->site(config('matomo-analytics.id_site'))->byLocalTime();

        $results = [];
        foreach ($analyticsData as $key => $analyticData) {
            $results[$analyticData->label] = $analyticData->nb_visits;
        }

        return $results;
    }

    /**
     * Visits by city data for table widgets
     *
     * @return array<int, array{city: string, region: string, country: string, image: string, nb_visits: int}>
     */
    public static function visitsByCity(?string $filter = null): array
    {
        $filter ??= 'T';

        /** @var \Carbon\CarbonPeriod $period */
        $period = MADataLookups::visitsByDeviceAndByCountryAndCity()[$filter];

        $analyticsData = collect(Matomo::geography()->period('range')->date("{$period->start->format('Y-m-d')},{$period->end->format('Y-m-d')}")->site(config('matomo-analytics.id_site'))->cities());

        return $analyticsData->map(fn ($pageRow): array => [
            'city' => $pageRow->city_name,
            'region' => $pageRow->region_name,
            'country' => $pageRow->country_name,
            'image' => $pageRow->logo,
            'nb_visits' => (int) $pageRow->nb_visits,
        ])->all();
    }

    /**
     * @return array<string, int|string>
     */
    public static function visitsByDevice(?string $filter = null): array
    {
        $filter ??= 'T';

        /** @var \Carbon\CarbonPeriod $period */
        $period = MADataLookups::visitsByDeviceAndByCountryAndCity()[$filter];

        $analyticsData = collect(Matomo::devices()->period('range')->date("{$period->start->format('Y-m-d')},{$period->end->format('Y-m-d')}")->site(config('matomo-analytics.id_site'))->types());

        $filtered = $analyticsData
            ->filter(function ($value, int $key) {
                return $value->nb_visits >= 1;
            })
            ->values();

        $results = [];

        foreach ($filtered as $key => $analyticData) {

            if ($analyticData->segment == 'deviceType==smartphone') {
                $label = __('matomo-analytics::widgets.smartphone');
            } else {
                $label = $analyticData->label;
            }
            $results[str($label)->append(' (' . number_format((int) $analyticData->nb_visits) . ')')->toString()] = $analyticData->nb_visits;
        }

        $total = 0;
        foreach ($results as $result) {
            $total += $result;
        }
        $results = Arr::sortDesc($results);

        $results[__('matomo-analytics::widgets.total') . ' (' . number_format($total) . ')'] = number_format($total);

        return $results;
    }

    /**
     * @return array<int, array{name: string, nb_visits: int}>
     */
    public static function mostVisitedPages(?string $filter = null): array
    {
        $filter ??= 'T';

        /** @var \Agencetwogether\MatomoAnalytics\Support\Period $period */
        $period = MADataLookups::mostVisitedAndTopReferrers()[$filter];

        $analyticsData = collect(Matomo::actions()->period('range')->date("{$period->startDate->format('Y-m-d')},{$period->endDate->format('Y-m-d')}")->site(config('matomo-analytics.id_site'))->pageTitles());

        return array_map(
            fn ($row): array => [
                'name' => (string) $row->label,
                'nb_visits' => (int) $row->nb_visits,
            ],
            $analyticsData->toArray()
        );
    }

    /**
     * Top referrers data for table widgets
     *
     * @return array<int, array{name: string, url: string, image: string, nb_visits: int}>
     */
    public static function topReferrers(?string $filter = null): array
    {
        $filter ??= 'T';

        /** @var \Agencetwogether\MatomoAnalytics\Support\Period $period */
        $period = MADataLookups::mostVisitedAndTopReferrers()[$filter];

        $analyticsData = collect(Matomo::referrers()->period('range')->date("{$period->startDate->format('Y-m-d')},{$period->endDate->format('Y-m-d')}")->site(config('matomo-analytics.id_site'))->searchEngines());

        return $analyticsData->map(fn ($pageRow): array => [
            'name' => $pageRow->label,
            'url' => $pageRow->url,
            'image' => $pageRow->logo,
            'nb_visits' => (int) $pageRow->nb_visits,
        ])->all();
    }

    /**
     * Visits by browsers data for table widgets
     *
     * @return array<int, array{name: string, image: string, nb_visits: int}>
     */
    public static function visitsByBrowser(?string $filter = null): array
    {
        $filter ??= 'T';

        /** @var \Agencetwogether\MatomoAnalytics\Support\Period $period */
        $period = MADataLookups::mostVisitedAndTopReferrers()[$filter];

        $analyticsData = collect(Matomo::devices()->period('range')->date("{$period->startDate->format('Y-m-d')},{$period->endDate->format('Y-m-d')}")->site(config('matomo-analytics.id_site'))->browsers());

        return $analyticsData->map(fn ($pageRow): array => [
            'name' => $pageRow->label,
            'image' => $pageRow->logo,
            'nb_visits' => (int) $pageRow->nb_visits,
        ])->all();
    }

    /**
     * Visits by models data for table widgets
     *
     * @return array<int, array{name: string, nb_visits: int}>
     */
    public static function visitsByModel(?string $filter = null): array
    {
        $filter ??= 'T';

        /** @var \Agencetwogether\MatomoAnalytics\Support\Period $period */
        $period = MADataLookups::mostVisitedAndTopReferrers()[$filter];

        $analyticsData = collect(Matomo::devices()->period('range')->date("{$period->startDate->format('Y-m-d')},{$period->endDate->format('Y-m-d')}")->site(config('matomo-analytics.id_site'))->models());

        return $analyticsData->map(fn ($pageRow): array => [
            'name' => $pageRow->label,
            'nb_visits' => (int) $pageRow->nb_visits,
        ])->all();
    }
}
