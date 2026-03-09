<?php

namespace Agencetwogether\MatomoAnalytics;

use Agencetwogether\MatomoAnalytics\Commands\MakeCustomMatomoDashboardPage;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class MatomoAnalyticsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('matomo-analytics')
            ->hasCommand(MakeCustomMatomoDashboardPage::class)
            ->hasConfigFile()
            ->hasViews()
            ->hasTranslations();
    }

    public function packageBooted(): void
    {
        WidgetManager::make()->boot();
    }
}
