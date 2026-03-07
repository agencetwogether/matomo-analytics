<?php

return [

    /**
     * This is the Matomo API key that allows you to work
     * with the API.
     */
    'api_key' => env('MATOMO_API_KEY'),

    /**
     * This is the URL of the Matomo installation that you want
     * to use the package with.
     */
    'base_url' => env('MATOMO_BASE_URL'),

    /**
     * This is the ID of your website that you want
     *  to use the package with
     */
    'id_site' => (int) env('MATOMO_ID_SITE'),

    /**
     * Dashboard Page
     */
    'dedicated_dashboard' => true,
    'dashboard_icon' => 'heroicon-m-chart-bar',

    /**
     * Widgets
     */
    'page_views' => [
        'filament_dashboard' => false,
        'global' => false,
    ],

    'visitors' => [
        'filament_dashboard' => false,
        'global' => false,
    ],

    'visitors_frequencies' => [
        'filament_dashboard' => false,
        'global' => false,
    ],

    'visitors_frequencies_duration' => [
        'filament_dashboard' => false,
        'global' => false,
    ],

    'visits' => [
        'filament_dashboard' => false,
        'global' => false,
    ],

    'visits_duration' => [
        'filament_dashboard' => false,
        'global' => false,
    ],

    'visits_by_country' => [
        'filament_dashboard' => false,
        'global' => false,
    ],

    'visits_by_city' => [
        'filament_dashboard' => false,
        'global' => false,
    ],

    'visits_per_hour' => [
        'filament_dashboard' => false,
        'global' => false,
    ],

    'visits_by_device' => [
        'filament_dashboard' => false,
        'global' => false,
    ],

    'visits_by_browser_list' => [
        'filament_dashboard' => false,
        'global' => false,
    ],

    'most_visited_pages' => [
        'filament_dashboard' => false,
        'global' => false,
    ],

    'top_referrers_list' => [
        'filament_dashboard' => false,
        'global' => false,
    ],

    'visits_by_model_list' => [
        'filament_dashboard' => false,
        'global' => false,
    ],

    /**
     * Trajectory Icons
     */
    'trending_up_icon' => 'heroicon-o-arrow-trending-up',
    'trending_down_icon' => 'heroicon-o-arrow-trending-down',
    'trending_steady_icon' => 'heroicon-o-arrows-right-left',

    /**
     * Trajectory Colors
     */
    'trending_up_color' => 'success',
    'trending_down_color' => 'danger',
    'trending_steady_color' => 'gray',

    /**
     * Cache TTL
     */
    'cache' => [
        'enabled' => true,

        // Cache TTL per filter (in minutes)
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
        'default_ttl' => 10,
    ],
];
