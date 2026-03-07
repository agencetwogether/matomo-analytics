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
            'today' => __('matomo-analytics::widgets.T'),
            'yesterday' => __('matomo-analytics::widgets.Y'),
            'last_week' => __('matomo-analytics::widgets.LW'),
            'last_month' => __('matomo-analytics::widgets.LM'),
            'last_7_days' => __('matomo-analytics::widgets.LSD'),
            'last_30_days' => __('matomo-analytics::widgets.LTD'),
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function mostVisitedAndTopReferrers(): array
    {
        return [
            'today' => __('matomo-analytics::widgets.T'),
            'this_week' => __('matomo-analytics::widgets.TW'),
            'this_month' => __('matomo-analytics::widgets.TM'),
            'this_year' => __('matomo-analytics::widgets.TY'),
        ];
    }
}
