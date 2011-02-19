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
 * @category   Tests
 * @package    Tests
 * @copyright  Copyright (C) 2011 Oggetto Web ltd (http://oggettoweb.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

require_once 'Mtool/Magento.php';

/**
 * Mtool_Magento class UntiTest
 *
 * @category   Tests
 * @package    Tests
 * @author     Valentin Sushkov <vsushkov@oggettoweb.com>
 */
class MagentoTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test getHomeDir method
     *
     */
    public function testGetHomeDir()
    {
        $this->assertEquals($_SERVER['HOME'], Mtool_Magento::getHomeDir());
    }
}