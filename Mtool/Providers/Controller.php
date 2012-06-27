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
 * @package    Mtool_Providers
 * @copyright  Copyright (C) 2011 Oggetto Web ltd (http://oggettoweb.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Controller provider
 *
 * @category   Mtool
 * @package    Mtool_Providers
 * @author     Eduard Melnitskiy <merlin3@bigmir.net>
 */
class Mtool_Providers_Controller extends Mtool_Providers_Entity
{
    /**
     * Get provider name
     *
     * @return string
     */
    public function getName()
    {
        return 'mage-controller';
    }

    /**
     * Create controller
     *
     * @param string $targetModule in format of companyname/modulename
     * @param string $controllerPath in format of mymodule/controller_path
     *
     * @return void
     */
    public function create($targetModule = null, $controllerPath = null)
    {
        $this->_createEntity(new Mtool_Codegen_Entity_Controller(), 'controller', $targetModule, $controllerPath);
    }

    /**
     * Create new controller with module auto-guessing
     *
     * @param string $controllerPath in format of mymodule/controller_path
     *
     * @return void
     */
    public function add($controllerPath = null)
    {
        $this->_createEntityWithAutoguess(new Mtool_Codegen_Entity_Controller(), 'controller', $controllerPath);
    }

    /**
     * Add new action to controller with module auto-guessing
     *
     * @param string $params in format of companyname/mymodule/controller_path/action
     *
     * @return void
     */
    public function actionAdd($params = null)
    {
        list($companyName, $namespace, $entityName, $actionName) = explode('/', $params);
        $module = new Mtool_Codegen_Entity_Module(getcwd(), $namespace, $companyName, $this->_getConfig());
        $controller = new Mtool_Codegen_Entity_Controller();

        $controller->addAction($entityName, $actionName, $module);
    }

    /**
     * Rewrite controller
     *
     * @param string $targetModule in format of companyname/modulename
     * @param string $originController in format of catalog/product
     * @param string $yourController in format of catalog_product
     *
     * @return void
     */
    public function rewrite($targetModule = null, $originController = null, $yourController = null)
    {
        $this->_rewriteEntity(new Mtool_Codegen_Entity_Controller(), 'controller', $targetModule, $originController, $yourController);
    }
}
