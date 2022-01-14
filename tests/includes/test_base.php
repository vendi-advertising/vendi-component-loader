<?php

declare(strict_types=1);

namespace Vendi\Shared\WordPress\ComponentLoader\Tests;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use PHPUnit\Framework\TestCase;

/**
 * @coversNothing
 */
class test_base extends TestCase
{
    //This is name of our FS root for testing
    private $_test_root_name = 'vendi-loader-test';

    //This is an instance of the Virtual File System
    private $_root;

    public function get_vfs_root(): vfsStreamDirectory
    {
        if (!$this->_root) {
            $this->_root = vfsStream::setup(
                $this->get_root_dir_name_no_trailing_slash(),
                null,
                []
            );
        }

        return $this->_root;
    }

    public function get_root_dir_name_no_trailing_slash(): string
    {
        return $this->_test_root_name;
    }

    public function setUp(): void
    {
        global $current_test_dir;
        $current_test_dir = $this->get_vfs_root()->url();
    }

    public function tearDown(): void
    {
        global $current_test_dir;
        $current_test_dir = null;
    }
}