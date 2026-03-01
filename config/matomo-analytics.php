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
        'global' => true,
    ],

    'visitors' => [
        'filament_dashboard' => false,
        'global' => true,
    ],

    'visitors_frequencies' => [
        'filament_dashboard' => false,
        'global' => true,
    ],

    'visitors_frequencies_duration' => [
        'filament_dashboard' => false,
        'global' => true,
    ],

    'visits' => [
        'filament_dashboard' => false,
        'global' => true,
    ],

    'visits_duration' => [
        'filament_dashboard' => false,
        'global' => true,
    ],

    'visits_by_country' => [
        'filament_dashboard' => false,
        'global' => true,
    ],

    'visits_by_city' => [
        'filament_dashboard' => false,
        'global' => true,
    ],

    'visits_per_hour' => [
        'filament_dashboard' => false,
        'global' => true,
    ],

    'visits_by_device' => [
        'filament_dashboard' => false,
        'global' => true,
    ],

    'visits_by_browser_list' => [
        'filament_dashboard' => false,
        'global' => true,
    ],

    'most_visited_pages' => [
        'filament_dashboard' => false,
        'global' => true,
    ],

    'top_referrers_list' => [
        'filament_dashboard' => false,
        'global' => true,
    ],

    'visits_by_model_list' => [
        'filament_dashboard' => false,
        'global' => true,
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
];
