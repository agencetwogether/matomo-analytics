<?php

namespace Agencetwogether\MatomoAnalytics\Pages;

use Agencetwogether\MatomoAnalytics\Contracts\HasMatomoWidgets;
use Agencetwogether\MatomoAnalytics\Widgets;
use Filament\Pages\Page;

abstract class MatomoBaseAnalyticsDashboard extends Page implements HasMatomoWidgets
{
    protected string $view = 'matomo-analytics::pages.matomo-base-analytics-dashboard';

    public static function getNavigationIcon(): ?string
    {
        return static::$navigationIcon ?? (string) config('matomo-analytics.dashboard_icon', 'heroicon-m-chart-bar');
    }

    /**
     * @return array<class-string<\Filament\Widgets\Widget>>
     */
    protected function getHeaderWidgets(): array
    {
        return [
            Widgets\MatomoApiStatusWidget::class,
            ...$this->getMatomoWidgets(),
        ];
    }
}
