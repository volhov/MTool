<?php
/**
 * Mage Tool
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   Mtool
 * @package    Mtool
 * @copyright  Copyright (C) 2011 Oggetto Web ltd (http://oggettoweb.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Mage tool manifest
 *
 * @category   Mtool
 * @package    Mtool
 * @author     Daniel Kocherga <dan@oggettoweb.com>
 */
class MtoolManifest implements Zend_Tool_Framework_Manifest_ProviderManifestable
{
    /**
     * Register autoload for the tool
     */

    public function __construct()
    {
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace('Mtool_');
    }

    /**
     * Get available providers
     * @return array
     */
    public function getProviders()
    {
        return array(
            new Mtool_Providers_Mtool(),
            new Mtool_Providers_Module(),
            new Mtool_Providers_Model(),
            new Mtool_Providers_Rmodel(),
            new Mtool_Providers_Helper(),
            new Mtool_Providers_Block(),
            new Mtool_Providers_Controller(),
        );
    }

}
