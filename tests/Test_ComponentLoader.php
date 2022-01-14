<?php

declare(strict_types=1);

namespace Vendi\Shared\WordPress\ComponentLoader\Tests;

use Symfony\Component\Filesystem\Path;
use Vendi\Shared\WordPress\ComponentLoader\VendiComponentLoader;

class Test_ComponentLoader extends test_base
{
    private function run_function_in_buffer_and_return(callable $func)
    {
        ob_start();
        $func();

        return ob_get_clean();
    }

    public function test__load_component_by_folder()
    {
        $expectedDir = Path::join($this->get_vfs_root()->url(), 'site');
        mkdir($expectedDir);
        $expectedFile = Path::join($expectedDir, 'test.php');
        $expectedContents = 'hello';

        file_put_contents($expectedFile, $expectedContents);

        $this->assertSame(
            $expectedContents,
            $this->run_function_in_buffer_and_return(
                function () {
                    VendiComponentLoader::load_component_by_folder('test', ['site']);
                }
            )
        );
    }

    public function test__load_component_by_folder__missing()
    {
        $expectedDir = Path::join($this->get_vfs_root()->url(), 'site');

        $this->assertStringContainsString(
            'Could not find template test in folder',
            $this->run_function_in_buffer_and_return(
                function () {
                    VendiComponentLoader::load_component_by_folder('test', ['site']);
                }
            )
        );
    }

    public function test__load_component_by_folder__custom_extension()
    {
        global $vendi_test_filters;
        $vendi_test_filters['vendi/component-loader/file-extensions'] = ['.twig'];

        $expectedDir = Path::join($this->get_vfs_root()->url(), 'site');
        mkdir($expectedDir);
        $expectedFile = Path::join($expectedDir, 'test.twig');
        $expectedContents = 'hello';

        file_put_contents($expectedFile, $expectedContents);

        $this->assertSame(
            $expectedContents,
            $this->run_function_in_buffer_and_return(
                function () {
                    VendiComponentLoader::load_component_by_folder('test', ['site']);
                }
            )
        );
    }

    public function test__load_component_by_folder__custom_extension__missing()
    {
        global $vendi_test_filters;
        $vendi_test_filters['vendi/component-loader/file-extensions'] = ['.twig'];

        $this->assertStringContainsString(
            'Could not find template test in folder',
            $this->run_function_in_buffer_and_return(
                function () {
                    VendiComponentLoader::load_component_by_folder('test', ['site']);
                }
            )
        );
    }
}