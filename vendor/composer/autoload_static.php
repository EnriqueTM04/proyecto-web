<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit92710aaa4ca595cc00d57177e805c5c1
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
        'E' => 
        array (
            'Enriq\\ProyectoWeb\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
        'Enriq\\ProyectoWeb\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit92710aaa4ca595cc00d57177e805c5c1::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit92710aaa4ca595cc00d57177e805c5c1::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit92710aaa4ca595cc00d57177e805c5c1::$classMap;

        }, null, ClassLoader::class);
    }
}
