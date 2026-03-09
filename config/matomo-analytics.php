<?php

return [

    /**
     * Matomo API authentication token used to access the Matomo Reporting API
     */
    'api_key' => env('MATOMO_API_KEY'),

    /**
     * Base URL of your Matomo instance (e.g. https://matomo.example.com)
     */
    'base_url' => env('MATOMO_BASE_URL'),

    /**
     * The Matomo site ID to retrieve analytics data for
     */
    'id_site' => env('MATOMO_ID_SITE'),

    /**
     * Dedicated plugin dashboard activation
     */
    'dedicated_dashboard' => true,
    'dashboard_icon' => 'heroicon-m-chart-bar',

    /**
     * Maximum number of items displayed in pie or doughnut charts
     * Remaining items are grouped into an "Others" category to keep charts readable
     */
    'max_items_in_pie' => 6,

    /**
     * Widget visibility configuration
     * Configure which widgets are enabled and where they should appear
     *
     * - filament_dashboard : display the widget on the default Filament dashboard
     * - plugin_dashboard   : display the widget on the Matomo plugin dashboard
     * - custom_pages       : allow the widget to be used on custom Filament pages
     */
    'widgets' => [

        /**
         * Widgets\PageViewsWidget::class
         */
        'page_views' => [
            'filament_dashboard' => false,
            'plugin_dashboard' => true,
            'custom_pages' => false,
        ],

        /**
         * Widgets\VisitorsWidget::class
         */
        'visitors' => [
            'filament_dashboard' => false,
            'plugin_dashboard' => true,
            'custom_pages' => false,
        ],

        /**
         * Widgets\VisitorsFrequenciesWidget::class
         */
        'visitors_frequencies' => [
            'filament_dashboard' => false,
            'plugin_dashboard' => true,
            'custom_pages' => false,
        ],

        /**
         * Widgets\VisitorsFrequenciesDurationWidget::class
         */
        'visitors_frequencies_duration' => [
            'filament_dashboard' => false,
            'plugin_dashboard' => true,
            'custom_pages' => false,
        ],

        /**
         * Widgets\VisitsWidget::class
         */
        'visits' => [
            'filament_dashboard' => false,
            'plugin_dashboard' => true,
            'custom_pages' => false,
        ],

        /**
         * Widgets\VisitsDurationWidget::class
         */
        'visits_duration' => [
            'filament_dashboard' => false,
            'plugin_dashboard' => true,
            'custom_pages' => false,
        ],

        /**
         * Widgets\VisitsByCountryWidget::class
         */
        'visits_by_country' => [
            'filament_dashboard' => false,
            'plugin_dashboard' => true,
            'custom_pages' => false,
        ],

        /**
         * Widgets\VisitsByCityWidget::class
         */
        'visits_by_city' => [
            'filament_dashboard' => false,
            'plugin_dashboard' => true,
            'custom_pages' => false,
        ],

        /**
         * Widgets\VisitsPerHourWidget::class
         */
        'visits_per_hour' => [
            'filament_dashboard' => false,
            'plugin_dashboard' => true,
            'custom_pages' => false,
        ],

        /**
         * Widgets\VisitsByDeviceWidget::class
         */
        'visits_by_device' => [
            'filament_dashboard' => false,
            'plugin_dashboard' => true,
            'custom_pages' => false,
        ],

        /**
         * Widgets\VisitsByBrowserListWidget::class
         */
        'visits_by_browser_list' => [
            'filament_dashboard' => false,
            'plugin_dashboard' => true,
            'custom_pages' => false,
        ],

        /**
         * Widgets\MostVisitedPagesWidget::class
         */
        'most_visited_pages' => [
            'filament_dashboard' => false,
            'plugin_dashboard' => true,
            'custom_pages' => false,
        ],

        /**
         * Widgets\TopReferrersListWidget::class
         */
        'top_referrers_list' => [
            'filament_dashboard' => false,
            'plugin_dashboard' => true,
            'custom_pages' => false,
        ],

        /**
         * Widgets\VisitsByModelListWidget::class
         */
        'visits_by_model_list' => [
            'filament_dashboard' => false,
            'plugin_dashboard' => true,
            'custom_pages' => false,
        ],
    ],

    /**
     * Icons used to indicate metric trends compared to the previous period
     */
    'trending_up_icon' => 'heroicon-o-arrow-trending-up',
    'trending_down_icon' => 'heroicon-o-arrow-trending-down',
    'trending_steady_icon' => 'heroicon-o-arrows-right-left',

    /**
     * Colors used to indicate metric trends
     */
    'trending_up_color' => 'success',
    'trending_down_color' => 'danger',
    'trending_steady_color' => 'gray',

    /**
     * Matomo API response caching configuration
     */
    'cache' => [
        /**
         * Enable or disable caching of Matomo API responses
         */
        'enabled' => true,
        /**
         * Cache TTL per filter (in minutes)
         * This allows different cache durations depending on the selected date range
         */
        'ttl' => [
            'today' => 5,
            'yesterday' => 60,
            'last_7_days' => 120,
            'last_30_days' => 360,
            'last_week' => 360,
            'last_month' => 1440,
            'this_week' => 60,
            'this_month' => 60,
            'this_year' => 60,
        ],
        /**
         * Default cache TTL (in minutes) used when no specific filter TTL is defined
         */
        'default_ttl' => 10,
    ],
];
