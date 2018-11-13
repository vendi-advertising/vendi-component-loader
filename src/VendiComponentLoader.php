<?php

declare(strict_types=1);

namespace Vendi\Shared\WordPress;

use Webmozart\PathUtil\Path;

final class VendiComponentLoader
{
    public const SHARED_PARENT_FOLDER = 'page-parts';
    public const SITE_FOLDER = [self::SHARED_PARENT_FOLDER, 'site'];
    public const PAGE_FOLDER = [self::SHARED_PARENT_FOLDER, 'page'];
    public const LOOP_FOLDER = [self::SHARED_PARENT_FOLDER, 'loop'];

    public static function load_site_component(string $name, string $sub_folder = null)
    {
        self::_do_load_xyz_component(self::SITE_FOLDER, $name, $sub_folder);
    }

    public static function load_page_component(string $name, string $sub_folder = null)
    {
        self::_do_load_xyz_component(self::PAGE_FOLDER, $name, $sub_folder);
    }

    public static function load_loop_component(string $name, string $sub_folder = null)
    {
        self::_do_load_xyz_component(self::LOOP_FOLDER, $name, $sub_folder);
    }

    public static function _do_load_xyz_component(array $folders, string $name, string $sub_folder = null)
    {
        //Support an optional parameter for a single subfolder
        if ($sub_folder) {
            $folders[] = $sub_folder;
        }

        self::load_component_by_folder($name, $folders);
    }

    public static function load_component_by_folder(string $name, array $folders)
    {

        //Prepend the template directory on to the start of the array
        array_unshift($folders, get_template_directory());

        //Append the file name to the end of the array
        array_push($folders, $name . '.php');

        //Merge into a giant path using the wonderful spread operator
        $path = Path::join(...$folders);


        if (is_readable($path)) {
            include $path;
            return;
        }

        //Output debug code to help template people know what file to create
        echo "\n";
        echo sprintf('<!-- Count not file template %1$s in folder(s) %2$s -->', esc_html($name), esc_html(implode('/', $folders)));
        echo "\n";
    }
}
