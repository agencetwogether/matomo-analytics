<?php

namespace Agencetwogether\MatomoAnalytics\Pages;

use Agencetwogether\MatomoAnalytics\Contracts\HasMatomoWidgets;
use Agencetwogether\MatomoAnalytics\Widgets;
use Illuminate\Contracts\Support\Htmlable;

class MatomoAnalyticsDashboard extends MatomoBaseAnalyticsDashboard implements HasMatomoWidgets
{
    public static function getNavigationIcon(): ?string
    {
        return (string) config('matomo-analytics.dashboard_icon', 'heroicon-m-chart-bar');
    }

    public static function getNavigationLabel(): string
    {
        return __('matomo-analytics::widgets.navigation_label');
    }

    public function getTitle(): string | Htmlable
    {
        return (string) __('matomo-analytics::widgets.title');
    }

    public static function canAccess(): bool
    {
        return config('matomo-analytics.dedicated_dashboard');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return static::canAccess() && static::$shouldRegisterNavigation;
    }

    /**
     * @return array<class-string<\Filament\Widgets\Widget>>
     */
    public function getMatomoWidgets(): array
    {
        return [
            Widgets\PageViewsWidget::class,
            Widgets\VisitorsWidget::class,
            Widgets\VisitsWidget::class,
            Widgets\VisitsDurationWidget::class,
            Widgets\VisitorsFrequenciesWidget::class,
            Widgets\VisitorsFrequenciesDurationWidget::class,
            Widgets\VisitsByCountryWidget::class,
            Widgets\VisitsByCityWidget::class,
            Widgets\VisitsPerHourWidget::class,
            Widgets\VisitsByBrowserListWidget::class,
            Widgets\VisitsByDeviceWidget::class,
            Widgets\VisitsByModelListWidget::class,
            Widgets\MostVisitedPagesWidget::class,
            Widgets\TopReferrersListWidget::class,
        ];
    }
}
