<?php

return [
    /**
     * Dashboard Page
     */
    'navigation_label' => 'Matomo Analytics Dashboard',
    'title' => 'Matomo Analytics Dashboard',

    /**
     * Widget Heading/Labels
     */
    'page_views' => 'Page Views',
    'visitors' => 'Unique Visitors',
    'visitors_frequencies' => 'Returning visitors',
    'visitors_frequencies_duration' => 'Avg. Returning Visitor Duration',
    'visits' => 'Visits',
    'visits_duration' => 'Avg. Visit Duration',
    'visits_by_country' => 'Visits By Country',
    'visits_per_hour' => 'Visits Per Hour',
    'visits_by_city' => 'Visits By City',
    'visits_by_device' => 'Visits By Device',
    'visits_by_browser' => 'Visits By Browser',
    'visits_by_model' => 'Visits By Model',
    'top_referrers' => 'Top Referrers',
    'most_visited_pages' => 'Most Visited Pages',

    /**
     * Filter Labels
     */
    'today' => 'Today',
    'yesterday' => 'Yesterday',
    'this_week' => 'This Week',
    'last_week' => 'Last Week',
    'last_month' => 'Last Month',
    'this_month' => 'This Month',
    'this_year' => 'This Year',
    'last_7_days' => 'Last 7 Days',
    'last_30_days' => 'Last 30 Days',

    /**
     * Trajectory Label Descriptions
     */
    'trending_up' => 'Increase',
    'trending_down' => 'Decrease',
    'steady' => 'Steady',

    /**
     * Doughnut
     */
    'total' => 'Total',
    'smartphone' => 'Smartphone',
    'nb_uniq_visitors' => 'Number of Visitors',
    'others' => 'Others',

    /**
     * Extra
     */
    'unknown' => 'Unknown',
    'no_data' => 'No data',
    'api_unreachable' => [
        'heading' => 'Matomo host unreachable',
        'description' => 'Last successful sync: :date. Widgets may display outdated or empty data',
        'next_call' => 'Wait :date to retry refresh data.',
    ],
];
