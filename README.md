<a href="https://github.com/agencetwogether/matomo-analytics" class="filament-hidden">
<img style="width: 100%; max-width: 100%;" alt="matomo-analytics-art" src="https://github.com/user-attachments/assets/22cf8736-af03-4fed-a52d-19ee9e2ff05f" >
</a>


<p align="center" class="flex items-center justify-center">
    <a href="https://filamentphp.com/docs/4.x/introduction/installation">
        <img alt="FILAMENT 4.x" src="https://img.shields.io/badge/FILAMENT-4.x-EBB304?style=for-the-badge">
    </a>
    <a href="https://filamentphp.com/docs/5.x/introduction/installation">
        <img alt="FILAMENT 5.x" src="https://img.shields.io/badge/FILAMENT-5.x-EBB304?style=for-the-badge">
    </a>
    <a href="https://packagist.org/packages/agencetwogether/matomo-analytics">
        <img alt="Packagist" src="https://img.shields.io/packagist/v/agencetwogether/matomo-analytics.svg?style=for-the-badge&logo=packagist">
    </a>
    <a href="https://github.com/agencetwogether/matomo-analytics/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain" class="filament-hidden">
        <img alt="Code Style Passing" src="https://img.shields.io/github/actions/workflow/status/agencetwogether/matomo-analytics/laravel-pint.yml?style=for-the-badge&logo=github&label=code%20style">
    </a>

<a href="https://packagist.org/packages/agencetwogether/matomo-analytics">
    <img alt="Downloads" src="https://img.shields.io/packagist/dt/agencetwogether/matomo-analytics.svg?style=for-the-badge" >
    </a>
<p>

# Matomo Analytics

Matomo Analytics integration for Filament Panels with a set of widgets to display your analytics data in a beautiful way.

> [!NOTE]  
> This package is an adaptation of [bezhanSalleh/filament-google-analytics](https://github.com/bezhanSalleh/filament-google-analytics), updated to work with Matomo Analytics.
Thanks to him


## Installation

You can install the package in a Laravel app that uses [Filament](https://filamentphp.com) via composer:

```bash
composer require agencetwogether/matomo-analytics
```

> [!IMPORTANT]
> If you have not set up a custom theme and are using Filament Panels follow the instructions in the [Filament Docs](https://filamentphp.com/docs/4.x/styling/overview#creating-a-custom-theme) first.

After setting up a custom theme add the following to your theme css file.

```css
@source '../../../../vendor/agencetwogether/matomo-analytics/resources/views/**/*';
@source '../../../../vendor/agencetwogether/matomo-analytics/src/{Widgets,Support}/*';
```

Then rebuild your assets:
```bash
npm run build
```

### First you need to retrieve credentials from your Matomo instance (self-hosted or cloud)
#### Matomo API Key
To generate a new API Key go to **Administration->Personal->Security** and click on **Create new token button**.
- Give a description as you want,
- Uncheck ```Only allow secure requests```
- And set or no an exire date.

#### Matomo Base Url
Copy Url of your instance with ```http``` or ```https``` prefix and remove slash (```/```) at the end.
For example, your base Url must be like : ```https://analyse.domain.com```

#### Matomo ID Site
To retrieve ID of your website you want to track, go to **Administration->Websites->Manage** and copy the ID below site name.

After that, add these credentials to the `.env` for your Filament PHP app:
```bash
MATOMO_API_KEY=
MATOMO_BASE_URL=
MATOMO_ID_SITE=
```
For example, it might look like this
```bash
MATOMO_API_KEY="d26fa64666d15073d9a8e49101422c06"
MATOMO_BASE_URL="https://analyse.domain.com"
MATOMO_ID_SITE=1
```

### Registering the plugin
```php
use Agencetwogether\MatomoAnalytics\MatomoAnalyticsPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            ...
            MatomoAnalyticsPlugin::make()
        ]);
}
```
## Usage

All the widgets are enabled by default for you to use them in your filament pages/resources. In order to enable the widgets for the default filament dashboard, you need to set the `filament_dashboard` option to `true` in the config file `matomo-analytics.php` for each widget you want to enable.

Publish the config files and set your settings:
```bash
 php artisan vendor:publish --tag=matomo-analytics-config
```

#### Available Widgets

```php
use Agencetwogether\MatomoAnalytics\Widgets;

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
```

#### Custom Dashboard
Though this plugin comes with a default dashboard, but sometimes you might want to change `navigationLabel` or `navigationGroup` or disable some `widgets` or any other options and given that the dashboard is a simple filament `page`; The easiest solution would be to disable the default dashboard and create a new `page`:

```bash
php artisan filament:page MyCustomDashboardPage
```
then register the widgets you want from the **Available Widgets** list either in the `getHeaderWidgets()` or `getFooterWidgets()`:

```php
<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Agencetwogether\MatomoAnalytics\Widgets;

class MyCustomDashboardPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.my-custom-dashboard-page';

    protected function getHeaderWidgets(): array
    {
        return [
            Widgets\PageViewsWidget::class,
            Widgets\VisitorsWidget::class,
            Widgets\VisitsWidget::class,
            Widgets\VisitsDurationWidget::class,
            Widgets\VisitorsFrequenciesWidget::class,
            Widgets\VisitorsFrequenciesDurationWidget::class,
            //Widgets\VisitsByCountryWidget::class,
            //Widgets\VisitsByCityWidget::class,
            Widgets\VisitsPerHourWidget::class,
            Widgets\VisitsByBrowserListWidget::class,
            Widgets\VisitsByDeviceWidget::class,
            Widgets\VisitsByModelListWidget::class,
            Widgets\MostVisitedPagesWidget::class,
            Widgets\TopReferrersListWidget::class,
        ];
    }
}
```
> [!NOTE]  
> In order to enable the widgets for the default filament dashboard, you need to set the `filament_dashboard` option to `true` in the config file `matomo-analytics.php` for each widget you want to enable.

## Preview
Widgets rendered in a dedicated dashboard (or any other page you create)
![Demo](https://github.com/agencetwogether/matomo-analytics/blob/main/previews/preview-light.png?raw=true "Filament Matomo Preview")
![Demo](https://github.com/agencetwogether/matomo-analytics/blob/main/previews/preview-dark.png?raw=true "Filament Matomo Preview")

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## Credits

- [Bezhan Salleh](https://github.com/bezhanSalleh)
- [Bernskiold](https://github.com/bernskiold)
- [Agence Twogether](https://github.com/agencetwogether)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
