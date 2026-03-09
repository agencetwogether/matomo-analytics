<?php

declare(strict_types=1);

namespace Agencetwogether\MatomoAnalytics\Support;

final class MAFilters
{
    /**
     * Provides a list of common filters for:
     *  - Page Views
     *  - Unique Visitors
     *  - Visits
     *  - Visits Duration
     *  - Visits by Device and Country
     *
     * @return array<string, string>
     */
    public static function common(): array
    {
        return [
            'today' => __('matomo-analytics::widgets.today'),
            'yesterday' => __('matomo-analytics::widgets.yesterday'),
            'last_week' => __('matomo-analytics::widgets.last_week'),
            'last_month' => __('matomo-analytics::widgets.last_month'),
            'last_7_days' => __('matomo-analytics::widgets.last_7_days'),
            'last_30_days' => __('matomo-analytics::widgets.last_30_days'),
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function mostVisitedAndTopReferrers(): array
    {
        return [
            'today' => __('matomo-analytics::widgets.today'),
            'this_week' => __('matomo-analytics::widgets.this_week'),
            'this_month' => __('matomo-analytics::widgets.this_month'),
            'this_year' => __('matomo-analytics::widgets.this_year'),
        ];
    }
}
