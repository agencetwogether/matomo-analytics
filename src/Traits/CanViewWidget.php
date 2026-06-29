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
        if (static::isLivewireUpdateRequest()) {
            return true;
        }

        $livewire = app('livewire')->current();

        if (! $livewire) {
            return false;
        }

        $config = static::getWidgetConfig();

        if ($livewire instanceof Dashboard) {
            return $config['filament_dashboard'];
        }

        if ($livewire instanceof MatomoAnalyticsDashboard) {
            return $config['plugin_dashboard'];
        }

        if ($livewire instanceof Page) {
            return $config['custom_pages'];
        }

        return false;
    }

    protected static function isLivewireUpdateRequest(): bool
    {
        return request()->is('livewire/update', 'livewire-*/update');
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
