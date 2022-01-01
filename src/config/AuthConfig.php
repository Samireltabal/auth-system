<?php 
    return [
        'version' => 'v0.0.1-Alpha',
        'prefix'  => 'api/auth',
        'middleware' => ['api'],
        'secure_middleware' => ['api', 'auth:api'],
        'admin_middleware' => ['api', 'role:' . env('ADMIN_ROLE', 'admin')],
    ];
