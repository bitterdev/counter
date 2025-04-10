<?php

namespace Concrete\Package\Counter;

use Bitter\Counter\Provider\ServiceProvider;
use Concrete\Core\Entity\Package as PackageEntity;
use Concrete\Core\Package\Package;

class Controller extends Package
{
    protected string $pkgHandle = 'counter';
    protected string $pkgVersion = '0.0.1';
    protected $appVersionRequired = '9.0.0';
    protected $pkgAutoloaderRegistries = [
        'src/Bitter/Counter' => 'Bitter\Counter',
    ];

    public function getPackageDescription(): string
    {
        return t('Animate numbers counting up to a target value when they become visible on screen.');
    }

    public function getPackageName(): string
    {
        return t('Counter');
    }

    public function on_start()
    {
        /** @var ServiceProvider $serviceProvider */
        /** @noinspection PhpUnhandledExceptionInspection */
        $serviceProvider = $this->app->make(ServiceProvider::class);
        $serviceProvider->register();
    }

    public function install(): PackageEntity
    {
        $pkg = parent::install();
        $this->installContentFile("data.xml");
        return $pkg;
    }

    public function upgrade()
    {
        parent::upgrade();
        $this->installContentFile("data.xml");
    }
}