<?php

declare(strict_types=1);

namespace Agencetwogether\MatomoAnalytics;

use Agencetwogether\MatomoAnalytics\Pages\MatomoAnalyticsDashboard;
use Filament\Contracts\Plugin;
use Filament\Panel;

class MatomoAnalyticsPlugin implements Plugin
{
    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'matomo-analytics';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->pages([
                MatomoAnalyticsDashboard::class,
            ])
            ->widgets([
                Widgets\MatomoApiStatusWidget::class,
                Widgets\MostVisitedPagesWidget::class,
                Widgets\PageViewsWidget::class,
                Widgets\TopReferrersListWidget::class,
                Widgets\VisitorsFrequenciesDurationWidget::class,
                Widgets\VisitorsFrequenciesWidget::class,
                Widgets\VisitorsWidget::class,
                Widgets\VisitsByBrowserListWidget::class,
                Widgets\VisitsByCityWidget::class,
                Widgets\VisitsByCountryWidget::class,
                Widgets\VisitsByDeviceWidget::class,
                Widgets\VisitsByModelListWidget::class,
                Widgets\VisitsDurationWidget::class,
                Widgets\VisitsPerHourWidget::class,
                Widgets\VisitsWidget::class,
            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
