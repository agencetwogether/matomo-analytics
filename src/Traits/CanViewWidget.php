<?php

namespace Agencetwogether\MatomoAnalytics\Traits;

use Agencetwogether\MatomoAnalytics\Pages\MatomoAnalyticsDashboard;
use Filament\Pages\Dashboard;
use Filament\Pages\Page;
use Illuminate\Support\Str;

trait CanViewWidget
{
    public static function canView(): bool
    {
        $livewire = app('livewire')->current();

        if (! $livewire) {
            return false;
        }

        $config = static::getWidgetConfig();

        // Dashboard Filament
        if ($livewire instanceof Dashboard) {
            return $config['filament_dashboard'];
        }

        // Dashboard plugin
        if ($livewire instanceof MatomoAnalyticsDashboard) {
            return $config['plugin_dashboard'];
        }

        // Custom Pages
        if ($livewire instanceof Page) {
            return $config['custom_pages'];
        }

        return false;
    }

    protected static function getWidgetConfig(): array
    {
        static $cache = [];

        $key = Str::of(static::class)
            ->after('Widgets\\')
            ->before('Widget')
            ->snake()
            ->toString();

        return $cache[$key] ??= config("matomo-analytics.widgets.$key", [
            'filament_dashboard' => false,
            'plugin_dashboard' => true,
            'custom_pages' => false,
        ]);
    }
}
