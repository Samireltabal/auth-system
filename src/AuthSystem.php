<?php
  
  namespace SamirEltabal\AuthSystem;

  class AuthSystem {
    public static function ping() {
        return response()
        ->json(
            ['message' => 'syncit auth is responding', 'version' => config('auth.version')],
        201);
    }
  }