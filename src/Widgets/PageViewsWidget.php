<?php

namespace Agencetwogether\MatomoAnalytics\Widgets;

use Agencetwogether\MatomoAnalytics\Support\MAFilters;
use Agencetwogether\MatomoAnalytics\Support\MAResponse;
use Agencetwogether\MatomoAnalytics\Support\MAStatsBuilder;
use Agencetwogether\MatomoAnalytics\Traits\CanViewWidget;
use Facades\Agencetwogether\MatomoAnalytics\Support\MADataLookups;
use Filament\Widgets\StatsOverviewWidget;

class PageViewsWidget extends StatsOverviewWidget
{
    use CanViewWidget;

    public ?string $filter = 'T';

    protected ?string $pollingInterval = null;

    protected int | string | array $columnSpan = 1;

    protected static ?int $sort = 1;

    /**
     * @var int | array<string, ?int> | null
     */
    protected int | array | null $columns = 1;

    protected function getStats(): array
    {
        return [
            MAStatsBuilder::make(__('matomo-analytics::widgets.page_views'))
                ->usingResponse(MAResponse::common(MADataLookups::pageViews(), $this->filter))
                ->withSelectFilter(MAFilters::common(), $this->filter)
                ->resolve(),
        ];
    }
}
