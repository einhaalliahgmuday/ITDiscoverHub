<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita3dee71a963108ff787dfee88aa40db0
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Stephenperez\\Frontend\\' => 22,
        ),
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Stephenperez\\Frontend\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita3dee71a963108ff787dfee88aa40db0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita3dee71a963108ff787dfee88aa40db0::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInita3dee71a963108ff787dfee88aa40db0::$classMap;

        }, null, ClassLoader::class);
    }
}
