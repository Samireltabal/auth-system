<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit7a80bfe125fcac854b163108e95605b5
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Samireltabal\\AuthSystem\\' => 24,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Samireltabal\\AuthSystem\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit7a80bfe125fcac854b163108e95605b5::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit7a80bfe125fcac854b163108e95605b5::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit7a80bfe125fcac854b163108e95605b5::$classMap;

        }, null, ClassLoader::class);
    }
}