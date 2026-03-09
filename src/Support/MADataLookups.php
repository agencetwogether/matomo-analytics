<?php

declare(strict_types=1);

namespace Agencetwogether\MatomoAnalytics\Support;

use Agencetwogether\MatomoAnalytics\Traits\PageViews;
use Agencetwogether\MatomoAnalytics\Traits\Visitors;
use Agencetwogether\MatomoAnalytics\Traits\VisitorsFrequencies;
use Agencetwogether\MatomoAnalytics\Traits\Visits;
use Agencetwogether\MatomoAnalytics\Traits\VisitsDuration;
use Agencetwogether\MatomoAnalytics\Traits\VisitsReturningDuration;

final class MADataLookups
{
    use PageViews;
    use Visitors;
    use VisitorsFrequencies;
    use Visits;
    use VisitsDuration;
    use VisitsReturningDuration;

    /**
     * @return array<string, array<string, int>>
     */
    public function pageViews(): array
    {
        return [
            'today' => $this->pageViewsData('today'),
            'yesterday' => $this->pageViewsData('yesterday'),
            'last_week' => $this->pageViewsData('last_week'),
            'last_month' => $this->pageViewsData('last_month'),
            'last_7_days' => $this->pageViewsData('last_7_days'),
            'last_30_days' => $this->pageViewsData('last_30_days'),
        ];

    }

    /**
     * @return array<string, array<string, int>>
     */
    public function visitorsFrequencies(): array
    {
        return [
            'today' => $this->visitorsFrequenciesData('today'),
            'yesterday' => $this->visitorsFrequenciesData('yesterday'),
            'last_week' => $this->visitorsFrequenciesData('last_week'),
            'last_month' => $this->visitorsFrequenciesData('last_month'),
            'last_7_days' => $this->visitorsFrequenciesData('last_7_days'),
            'last_30_days' => $this->visitorsFrequenciesData('last_30_days'),
        ];
    }

    /**
     * @return array<string, array<string, int>>
     */
    public function visits(): array
    {
        return [
            'today' => $this->visitsData('today'),
            'yesterday' => $this->visitsData('yesterday'),
            'last_week' => $this->visitsData('last_week'),
            'last_month' => $this->visitsData('last_month'),
            'last_7_days' => $this->visitsData('last_7_days'),
            'last_30_days' => $this->visitsData('last_30_days'),
        ];
    }

    /**
     * @return array<string, array<string, int>>
     */
    public function visitsDuration(): array
    {
        return [
            'today' => $this->visitDurationData('today'),
            'yesterday' => $this->visitDurationData('yesterday'),
            'last_week' => $this->visitDurationData('last_week'),
            'last_month' => $this->visitDurationData('last_month'),
            'last_7_days' => $this->visitDurationData('last_7_days'),
            'last_30_days' => $this->visitDurationData('last_30_days'),
        ];
    }

    /**
     * @return array<string, array<string, int>>
     */
    public function visitsReturningDuration(): array
    {
        return [
            'today' => $this->visitReturningDurationData('today'),
            'yesterday' => $this->visitReturningDurationData('yesterday'),
            'last_week' => $this->visitReturningDurationData('last_week'),
            'last_month' => $this->visitReturningDurationData('last_month'),
            'last_7_days' => $this->visitReturningDurationData('last_7_days'),
            'last_30_days' => $this->visitReturningDurationData('last_30_days'),
        ];
    }

    /**
     * @return array<string, array<string, int>>
     */
    public function visitors(): array
    {
        return [
            'today' => $this->visitorsData('today'),
            'yesterday' => $this->visitorsData('yesterday'),
            'last_week' => $this->visitorsData('last_week'),
            'last_month' => $this->visitorsData('last_month'),
            'last_7_days' => $this->visitorsData('last_7_days'),
            'last_30_days' => $this->visitorsData('last_30_days'),
        ];
    }
}
