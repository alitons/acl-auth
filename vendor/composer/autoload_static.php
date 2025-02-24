<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit55893e2a7dc75e22431931e8c7fa2f08
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'Acl\\Auth\\Tests\\' => 15,
            'Acl\\Auth\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Acl\\Auth\\Tests\\' => 
        array (
            0 => __DIR__ . '/../..' . '/tests',
        ),
        'Acl\\Auth\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit55893e2a7dc75e22431931e8c7fa2f08::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit55893e2a7dc75e22431931e8c7fa2f08::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit55893e2a7dc75e22431931e8c7fa2f08::$classMap;

        }, null, ClassLoader::class);
    }
}
