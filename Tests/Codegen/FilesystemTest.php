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
 * @package    Tests_Codegen
 * @copyright  Copyright (C) 2011 Oggetto Web ltd (http://oggettoweb.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
require_once 'Mtool/Codegen/Filesystem.php';

/**
 * Mtool_Codegen_Filesystem class UntiTest
 *
 * @category   Tests
 * @package    Tests_Codegen
 * @author     Valentin Sushkov <vsushkov@oggettoweb.com>
 */
class Codegen_FilesystemTest extends PHPUnit_Framework_TestCase
{
    protected function _setVfsSream()
    {
        @include_once 'vfsStream/vfsStream.php';
        if (!class_exists('vfsStreamWrapper')) {
            $this->markTestSkipped('vfsStream is not available - skipping');
        } else {
            vfsStream::setup();
        }
    }

    /**
     * Mocking the filesystem
     *
     * @return null
     */
    public function setUp()
    {
        $this->_setVfsSream();
    }

    public function dirs()
    {
        return array(
            array('dir'),
            array('dir/subdir'),
        );
    }

    /**
     * Test for Mtool_Codegen_Filesystem::mkdir()
     *
     * @dataProvider dirs
     * @link http://code.google.com/p/bovigo/wiki/vfsStreamDocsFilemode#vfsStream_and_chmod()
     * @return null
     */
    public function testMkdir($dirName)
    {
        // Must create a new directory
        $this->assertFalse(vfsStreamWrapper::getRoot()->hasChild($dirName));

        Mtool_Codegen_Filesystem::mkdir(vfsStream::url('root/' . $dirName));
        $this->assertTrue(vfsStreamWrapper::getRoot()->hasChild($dirName));

        // Must return null if folder already exists
        $this->assertNull(Mtool_Codegen_Filesystem::mkdir(vfsStream::url('root/' . $dirName)));
    }

    /**
     * Test for Mtool_Codegen_Filesystem::read()
     *
     * @return null
     */
    public function testRead()
    {
        // Must return content of a file
        vfsStream::newFile('testfile')->at(vfsStreamWrapper::getRoot());

        $fileContent = "/**
                         * Test for Mtool_Codegen_Filesystem::write()
                         *
                         * @return null
                         */"
        ;

        $handle = fopen(vfsStream::url('root/testfile'), 'w+');
        fwrite($handle, $fileContent);

        $this->assertEquals($fileContent, Mtool_Codegen_Filesystem::read(vfsStream::url('root/testfile')));

    }

    /**
     * Test for Mtool_Codegen_Filesystem::write()
     *
     * @return null
     */
    public function testWrite()
    {
        // Must write into a file
        $fileContent = "/**
                         * Test for Mtool_Codegen_Filesystem::write()
                         *
                         * @return null
                         */"
        ;
        Mtool_Codegen_Filesystem::write(vfsStream::url('root/testfile'), $fileContent);

        $handle = fopen(vfsStream::url('root/testfile'), 'r');

        $this->assertStringEqualsFile(vfsStream::url('root/testfile'), $fileContent);
    }

    /**
     * Test for Mtool_Codegen_Filesystem::exists()
     *
     * @return null
     */
    public function testExists()
    {
        // Must return true if a file exists
        vfsStream::newFile('test')->at(vfsStreamWrapper::getRoot());
        $this->assertTrue(Mtool_Codegen_Filesystem::exists('root/test'));

        // Must return false if a file doesn't exist
        $this->assertFalse(Mtool_Codegen_Filesystem::exists('root/fail'));
    }

    /**
     * Test for Mtool_Codegen_Filesystem::slash()
     *
     * @return null
     */
    public function testSlash()
    {
        // Must add diretory separator to the end of the path if it's not there
        $this->assertEquals('/', Mtool_Codegen_Filesystem::slash('/'));
        $this->assertEquals('test/', Mtool_Codegen_Filesystem::slash('test'));
        $this->assertEquals('test/', Mtool_Codegen_Filesystem::slash('test/'));
        $this->assertEquals('test/test/', Mtool_Codegen_Filesystem::slash('test/test'));
        $this->assertEquals('test/test/', Mtool_Codegen_Filesystem::slash('test/test/'));
    }

}