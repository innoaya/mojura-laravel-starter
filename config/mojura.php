<?php

return [

    /**
     * Register routes under routes/web and routes/api by the service provider or not.
     */
    'enable_routes' => env('MOJURA_ENABLE_ROUTES', true),

    /**
     * Prefix for api routes
     */
    'api_routes_prefix' => env('MOJURA_API_ROUTES_PREFIX', 'api'),

    /**
     * Prefix for web routes
     */
    'web_routes_prefix' => env('MOJURA_WEB_ROUTES_PREFIX', ''),

];
