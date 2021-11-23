<?php

namespace SamirEltabal\AuthSystem;

use Illuminate\Support\Facades\Facade;

/**
 * @see \VendorName\Skeleton\Skeleton
 */
class AuthSystemFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'authsystem';
    }

    public static function ping() {
        return response()
        ->json(
            ['message' => 'syncit auth is responding', 'version' => config('auth.version')],
        201);
    }
}