<?php

declare(strict_types=1);

namespace Agencetwogether\MatomoAnalytics\Support;

use Agencetwogether\MatomoAnalytics\Traits\PageViews;
use Agencetwogether\MatomoAnalytics\Traits\Visitors;
use Agencetwogether\MatomoAnalytics\Traits\VisitorsFrequencies;
use Agencetwogether\MatomoAnalytics\Traits\Visits;
use Agencetwogether\MatomoAnalytics\Traits\VisitsDuration;
use Agencetwogether\MatomoAnalytics\Traits\VisitsReturningDuration;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

final class MADataLookups
{
    use PageViews;
    use Visitors;
    use VisitorsFrequencies;
    use Visits;
    use VisitsDuration;
    use VisitsReturningDuration;

    /**
     * @return array<string, Period>
     */
    public function mostVisitedAndTopReferrers(): array
    {
        return [
            'T' => Period::days(1),
            'TW' => Period::days(7),
            'TM' => Period::months(1),
            'TY' => Period::years(1),
        ];
    }

    /**
     * @return array<string, array<string, int>>
     */
    public function pageViews(): array
    {
        return [
            'T' => $this->pageViewsToday(),
            'Y' => $this->pageViewsYesterday(),
            'LW' => $this->pageViewsLastWeek(),
            'LM' => $this->pageViewsLastMonth(),
            'LSD' => $this->pageViewsLastSevenDays(),
            'LTD' => $this->pageViewsLastThirtyDays(),
        ];
    }

    /**
     * @return array<string, array<string, int>>
     */
    public function visitorsFrequencies(): array
    {
        return [
            'T' => $this->visitorsFrequenciesToday(),
            'Y' => $this->visitorsFrequenciesYesterday(),
            'LW' => $this->visitorsFrequenciesLastWeek(),
            'LM' => $this->visitorsFrequenciesLastMonth(),
            'LSD' => $this->visitorsFrequenciesLastSevenDays(),
            'LTD' => $this->visitorsFrequenciesLastThirtyDays(),
        ];
    }

    /**
     * @return array<string, array<string, int>>
     */
    public function visits(): array
    {
        return [
            'T' => $this->visitsToday(),
            'Y' => $this->visitsYesterday(),
            'LW' => $this->visitsLastWeek(),
            'LM' => $this->visitsLastMonth(),
            'LSD' => $this->visitsLastSevenDays(),
            'LTD' => $this->visitsLastThirtyDays(),
        ];
    }

    /**
     * @return array<string, array<string, int>>
     */
    public function visitsDuration(): array
    {
        return [
            'T' => $this->visitDurationToday(),
            'Y' => $this->visitDurationYesterday(),
            'LW' => $this->visitDurationLastWeek(),
            'LM' => $this->visitDurationLastMonth(),
            'LSD' => $this->visitDurationLastSevenDays(),
            'LTD' => $this->visitDurationLastThirtyDays(),
        ];
    }

    /**
     * @return array<string, array<string, int>>
     */
    public function visitsReturningDuration(): array
    {
        return [
            'T' => $this->visitReturningDurationToday(),
            'Y' => $this->visitReturningDurationYesterday(),
            'LW' => $this->visitReturningDurationLastWeek(),
            'LM' => $this->visitReturningDurationLastMonth(),
            'LSD' => $this->visitReturningDurationLastSevenDays(),
            'LTD' => $this->visitReturningDurationLastThirtyDays(),
        ];
    }

    /**
     * @return array<string, CarbonPeriod>
     */
    public function visitsByDeviceAndByCountryAndCity(): array
    {
        return [
            'T' => CarbonPeriod::create(Carbon::yesterday(), Carbon::today()),
            'Y' => CarbonPeriod::create(Carbon::yesterday()->clone()->subDay(), Carbon::yesterday()),
            'LW' => CarbonPeriod::create(
                Carbon::today()
                    ->clone()
                    ->startOfWeek(Carbon::SUNDAY)
                    ->subWeek(),
                Carbon::today()
                    ->clone()
                    ->subWeek()
                    ->endOfWeek(Carbon::SATURDAY)
            ),
            'LM' => CarbonPeriod::create(
                Carbon::today()
                    ->clone()
                    ->startOfMonth()
                    ->subMonth(),
                Carbon::today()
                    ->clone()
                    ->startOfMonth()
                    ->subMonth()
                    ->endOfMonth()
            ),
            'LSD' => CarbonPeriod::create(
                Carbon::yesterday()
                    ->clone()
                    ->subDays(6),
                Carbon::yesterday()
            ),
            'LTD' => CarbonPeriod::create(
                Carbon::yesterday()
                    ->clone()
                    ->subDays(29),
                Carbon::yesterday()
            ),
        ];
    }

    /**
     * @return array<string, CarbonPeriod>
     */
    public function visitsPerHour(): array
    {
        return [
            'T' => CarbonPeriod::create(Carbon::today()->clone(), Carbon::today()->endOfDay()),
            'Y' => CarbonPeriod::create(Carbon::yesterday()->clone(), Carbon::yesterday()->endOfDay()),
            'LW' => CarbonPeriod::create(
                Carbon::today()
                    ->clone()
                    ->startOfWeek(Carbon::SUNDAY)
                    ->subWeek(),
                Carbon::today()
                    ->clone()
                    ->subWeek()
                    ->endOfWeek(Carbon::SATURDAY)
            ),
            'LM' => CarbonPeriod::create(
                Carbon::today()
                    ->clone()
                    ->startOfMonth()
                    ->subMonth(),
                Carbon::today()
                    ->clone()
                    ->startOfMonth()
                    ->subMonth()
                    ->endOfMonth()
            ),
            'LSD' => CarbonPeriod::create(
                Carbon::yesterday()
                    ->clone()
                    ->subDays(6),
                Carbon::yesterday()
            ),
            'LTD' => CarbonPeriod::create(
                Carbon::yesterday()
                    ->clone()
                    ->subDays(29),
                Carbon::yesterday()
            ),
        ];
    }

    /**
     * @return array<string, array<string, int>>
     */
    public function visitors(): array
    {
        return [
            'T' => $this->visitorsToday(),
            'Y' => $this->visitorsYesterday(),
            'LW' => $this->visitorsLastWeek(),
            'LM' => $this->visitorsLastMonth(),
            'LSD' => $this->visitorsLastSevenDays(),
            'LTD' => $this->visitorsLastThirtyDays(),
        ];
    }
}
