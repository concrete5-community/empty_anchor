<?php

namespace Concrete\Package\EmptyAnchor;

use Concrete\Core\Database\EntityManager\Provider\ProviderInterface;
use Concrete\Core\Package\Package;

defined('C5_EXECUTE') or die('Access denied.');

/**
 * The ProgePack package controller.
 */
class Controller extends Package implements ProviderInterface
{
    /**
     * The package handle.
     *
     * @var string
     */
    protected $pkgHandle = 'empty_anchor';

    /**
     * The package version.
     *
     * @var string
     */
    protected $pkgVersion = '1.0.0';

    /**
     * The minimum concrete5 version.
     *
     * @var string
     */
    protected $appVersionRequired = '8.2.0';

    /**
     * Map folders to PHP namespaces, for automatic class autoloading.
     *
     * @var array
     */
    protected $pkgAutoloaderRegistries = [
    ];

    /**
     * {@inheritdoc}
     */
    public function getPackageName()
    {
        return t('Empty Anchor');
    }

    /**
     * {@inheritdoc}
     */
    public function getPackageDescription()
    {
        return t('Add a simple empty anchor to your webpage.');
    }

    /**
     * {@inheritdoc}
     *
     * @see \Concrete\Core\Package\Package::install()
     */
    public function install()
    {
        parent::install();
        $this->installContentFile('install.xml');
    }

    /**
     * {@inheritdoc}
     *
     * @see \Concrete\Core\Package\Package::upgrade()
     */
    public function upgrade()
    {
        parent::upgrade();
        $this->installContentFile('install.xml');
    }

    /**
     * {@inheritdoc}
     *
     * @see \Concrete\Core\Database\EntityManager\Provider\ProviderInterface::getDrivers()
     */
    public function getDrivers()
    {
        return [];
    }
}
