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
 * @package    Mtool_Codegen
 * @copyright  Copyright (C) 2011 Oggetto Web ltd (http://oggettoweb.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Controller code generator
 *
 * @category   Mtool
 * @package    Mtool_Codegen
 * @subpackage Entity
 * @author     Eduard Melnitskiy <merlin3@bigmir.net>
 */
class Mtool_Codegen_Entity_Controller extends Mtool_Codegen_Entity_Abstract
{
    /**
     * Entity folder name
     *
     * @var string
     *
     * @return void
     */
    protected $_folderName = 'controllers';

    /**
     * Create template name
     *
     * @var string
     *
     * @return void
     */
    protected $_createTemplate = 'controller_blank';

    /**
     * Rewrite template name
     *
     * @var string
     *
     * @return void
     */
    protected $_rewriteTemplate = 'controller_rewrite';

    /**
     * Update template name
     *
     * @var string
     *
     * @return void
     */
    protected $_updateTemplate = 'controller_update';

    /**
     * Entity name
     *
     * @var string
     *
     * @return void
     */
    protected $_entityName = '';

    /**
     * Namespace in config file
     *
     * @var string
     *
     * @return void
     */
    protected $_configNamespace = 'controllers';

    /**
     * Create new entity
     *
     * @param string $namespace
     * @param string $path
     * @param Mtool_Codegen_Entity_Module $module
     */
    public function create($namespace, $path, Mtool_Codegen_Entity_Module $module)
    {
        // Create class file
        $this->createClass($path . 'Controller', $this->_createTemplate, $module);

        // Create namespace in config if not exist
        $config = new Mtool_Codegen_Config($module->getConfigPath('config.xml'));
        $config->set("frontend/routers/{$module->getModuleName()}/use", 'standard');
        $config->set("frontend/routers/{$module->getModuleName()}/args/module", $module->getName());
        $config->set("frontend/routers/{$module->getModuleName()}/args/frontName", $module->getModuleName());

        // Add page related with controller to the layout xml
        $layoutFile = $module->getModuleFrontendLayoutDir() . DIRECTORY_SEPARATOR . $module->getModuleName() . '.xml';
        if (!file_exists($layoutFile)) {
            $name = $module->getName();

            $params = array(
                'module_name' => $name,
                'module' => $module->getModuleName(),
                'company_name' => $module->getCompanyName(),
                'year' => date('Y'),
            );


            $configTemplate = new Mtool_Codegen_Template('module_layout');

            $configTemplate
                ->setParams(array_merge($params, $module->getTemplateParams()))
                ->move($module->getModuleFrontendLayoutDir(), $module->getModuleName() . '.xml');

            $config->set("frontend/layout/updates/{$module->getModuleName()}/file", $module->getModuleName() . '.xml');
        }

        $config = new Mtool_Codegen_Config($layoutFile);

        $config->set("{$module->getModuleName()}_" . strtolower($path) . "_index/label", $path);

    }

    /**
     * Rewrite Magento entity. Controllers have specific behavior - no alias in core configs.
     *
     * @param string $originNamespace
     * @param string $originPath
     * @param string $path
     * @param Mtool_Codegen_Entity_Module $module
     *
     * @return void
     */
    public function rewrite($originNamespace, $originPath, $path, Mtool_Codegen_Entity_Module $module)
    {
        // Create own class
        $originPathSteps = $this->_ucPath(explode('_', $originPath));
        $originModuleName = ucfirst($originNamespace);
        $originClassName = implode('_', $originPathSteps);
        $params = array(
            'original_class_name' => "Mage_{$originModuleName}_{$this->_entityName}_{$originClassName}"
        );
        $className = $this->createClass($path, $this->_rewriteTemplate, $module, $params);

        // Register rewrite in config
        $config = new Mtool_Codegen_Config($module->getConfigPath('config.xml'));
        $config->set("global/{$this->_configNamespace}/{$originNamespace}/rewrite/{$originPath}", $className);
    }

    public function addAction($entityName, $actionName, Mtool_Codegen_Entity_Module $module){
        $this->modifyClass($entityName . 'Controller', $this->_updateTemplate, $actionName, $module);
    }
}
