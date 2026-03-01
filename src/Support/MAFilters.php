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
            'T' => __('matomo-analytics::widgets.T'),
            'Y' => __('matomo-analytics::widgets.Y'),
            'LW' => __('matomo-analytics::widgets.LW'),
            'LM' => __('matomo-analytics::widgets.LM'),
            'LSD' => __('matomo-analytics::widgets.LSD'),
            'LTD' => __('matomo-analytics::widgets.LTD'),
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function mostVisitedAndTopReferrers(): array
    {
        return [
            'T' => __('matomo-analytics::widgets.T'),
            'TW' => __('matomo-analytics::widgets.TW'),
            'TM' => __('matomo-analytics::widgets.TM'),
            'TY' => __('matomo-analytics::widgets.TY'),
        ];
    }
}
