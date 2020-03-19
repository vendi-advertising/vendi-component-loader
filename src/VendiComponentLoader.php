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
    public const COMPONENT_FOLDER = [self::SHARED_PARENT_FOLDER, 'component'];

    public static function load_component_component_with_state(string $name, array $object_state = null, string $sub_folder = null)
    {
        self::_do_load_xyz_component(self::COMPONENT_FOLDER, $name, $sub_folder, $object_state);
    }

    public static function load_site_component_with_state(string $name, array $object_state = null, string $sub_folder = null)
    {
        self::_do_load_xyz_component(self::SITE_FOLDER, $name, $sub_folder, $object_state);
    }

    public static function load_page_component_with_state(string $name, array $object_state = null, string $sub_folder = null)
    {
        self::_do_load_xyz_component(self::PAGE_FOLDER, $name, $sub_folder, $object_state);
    }

    public static function load_loop_component_with_state(string $name, array $object_state = null, string $sub_folder = null)
    {
        self::_do_load_xyz_component(self::LOOP_FOLDER, $name, $sub_folder, $object_state);
    }
    
    public static function load_component_component(string $name, string $sub_folder = null)
    {
        self::load_component_component_with_state($name, null, $sub_folder);
    }

    public static function load_site_component(string $name, string $sub_folder = null)
    {
        self::load_site_component_with_state($name, null, $sub_folder);
    }

    public static function load_page_component(string $name, string $sub_folder = null)
    {
        self::load_page_component_with_state($name, null, $sub_folder);
    }

    public static function load_loop_component(string $name, string $sub_folder = null)
    {
        self::load_loop_component_with_state($name, null, $sub_folder);
    }

    public static function _do_load_xyz_component(array $folders, string $name, string $sub_folder = null, array $object_state = null)
    {
        //Support an optional parameter for a single subfolder
        if ($sub_folder) {
            $folders[] = $sub_folder;
        }

        self::load_component_by_folder($name, $folders, $object_state);
    }

    public static function load_component_by_folder(string $name, array $folders, array $object_state = null)
    {

        //Prepend the template directory on to the start of the array
        array_unshift($folders, get_template_directory());

        //Append the file name to the end of the array
        array_push($folders, $name . '.php');

        //Merge into a giant path using the wonderful spread operator
        $path = Path::join(...$folders);

        if (is_readable($path)) {

            //This will hold a backup copy of the object state.
            //NOTE: If we aren't given an object state, we will intentionally be setting
            //the global state to null to avoid accidental usage which could lead to bad
            //programming practice.
            global $vendi_component_object_state;
            $backup_state = $vendi_component_object_state;

            if ($object_state && count($object_state)) {
                $vendi_component_object_state = $object_state;
            } else {
                $vendi_component_object_state = null;
            }

            include $path;

            $vendi_component_object_state = $backup_state;

            return;
        }

        //Output debug code to help template people know what file to create
        echo "\n";
        if (function_exists('do_action')) {
            \do_action('vendi/component-loaded/missing-template', $name, $folders, $path);
        }
        echo sprintf('<!-- Count not file template %1$s in folder(s) %2$s -->', esc_html($name), esc_html(implode('/', $folders)));
        echo "\n";
    }
}
