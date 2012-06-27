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
 * Magento configuration class
 *
 * @category   Mtool
 * @package    Mtool
 * @author     Daniel Kocherga <dan@oggettoweb.com>
 */
class Mtool_Magento
{
    /**
     * Magento root path with a slash on the ending
     *
     * @var string
     */
    protected $_root;

    /**
     * Configure path to magento
     *
     * @param string $path - absolute path tp magento root
     */
    public function __construct($root)
    {
        $this->_root = Mtool_Codegen_Filesystem::slash($root);
    }

    /**
     * Get Magento codepool path
     *
     * @param string $pool (local/community)
     * @return string
     */
    public function getCodepoolPath($pool = 'local')
    {
        return $this->_root . 'app' .
            DIRECTORY_SEPARATOR . 'code' .
            DIRECTORY_SEPARATOR . $pool .
            DIRECTORY_SEPARATOR;
    }

    /**
     * Get Magento modules config path
     *
     * @param string $pool (local/community)
     * @return string
     */
    public function getModulesConfigPath()
    {
        return $this->_root . 'app' .
            DIRECTORY_SEPARATOR . 'etc' .
            DIRECTORY_SEPARATOR . 'modules' .
            DIRECTORY_SEPARATOR;
    }

    /**
     * Find file in the code pools
     *
     * @param string $search
     * @param string|null $where
     * @return RegexIterator
     */
    public function findInCode($search, $where = null)
    {
        if($where === null)
            $where = $this->_root . 'app' . DIRECTORY_SEPARATOR . 'code';
        return Mtool_Codegen_Browser::find($search, $where);
    }

    /**
     * Get user's home directory path
     *
     * @return string
     */
    public static function getHomeDir()
    {
        return $_SERVER['HOME'];
    }

    /**
     * Get project root directory path
     *
     * @return string
     */
    public static function getRoot()
    {
        return rtrim(Mtool_Codegen_Filesystem::slash(getcwd()), '/');
    }

    /**
     * Get Mtool directory path
     *
     * @return string
     */
    public static function getMtoolDir()
    {
        return dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'Mtool';
    }

    /**
     * Get design frontend directory path
     *
     * @return string
     */
    public function getDesignFrontendDir()
    {
        return $this->_root . 'app' .
            DIRECTORY_SEPARATOR . 'design' .
            DIRECTORY_SEPARATOR . 'frontend' .
            DIRECTORY_SEPARATOR;
    }

    /**
     * Get design adminhtml directory path
     *
     * @return string
     */
    public function getDesignAdminhtmlDir()
    {
        return $this->_root . 'app' .
            DIRECTORY_SEPARATOR . 'design' .
            DIRECTORY_SEPARATOR . 'adminhtml' .
            DIRECTORY_SEPARATOR . 'default' .
            DIRECTORY_SEPARATOR . 'default' .
            DIRECTORY_SEPARATOR;
    }
}
