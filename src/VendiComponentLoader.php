<?php

declare(strict_types=1);

namespace Vendi\Shared\WordPress;

use Symfony\Component\Filesystem\Path;

final class VendiComponentLoader
{
    public const SHARED_PARENT_FOLDER = 'page-parts';
    public const SITE_FOLDER = [self::SHARED_PARENT_FOLDER, 'site'];
    public const PAGE_FOLDER = [self::SHARED_PARENT_FOLDER, 'page'];
    public const LOOP_FOLDER = [self::SHARED_PARENT_FOLDER, 'loop'];
    public const SUB_COMPONENT_FOLDER = [self::SHARED_PARENT_FOLDER, 'sub-component'];
    public const COMPONENT_FOLDER = [self::SHARED_PARENT_FOLDER, 'component'];

    public static function load_sub_component_with_state(string $name, array $object_state = null, string $sub_folder = null): void
    {
        self::_do_load_xyz_component(self::SUB_COMPONENT_FOLDER, $name, $sub_folder, $object_state);
    }

    public static function load_component_component_with_state(string $name, array $object_state = null, string $sub_folder = null): void
    {
        self::_do_load_xyz_component(self::COMPONENT_FOLDER, $name, $sub_folder, $object_state);
    }

    public static function load_site_component_with_state(string $name, array $object_state = null, string $sub_folder = null): void
    {
        self::_do_load_xyz_component(self::SITE_FOLDER, $name, $sub_folder, $object_state);
    }

    public static function load_page_component_with_state(string $name, array $object_state = null, string $sub_folder = null): void
    {
        self::_do_load_xyz_component(self::PAGE_FOLDER, $name, $sub_folder, $object_state);
    }

    public static function load_loop_component_with_state(string $name, array $object_state = null, string $sub_folder = null): void
    {
        self::_do_load_xyz_component(self::LOOP_FOLDER, $name, $sub_folder, $object_state);
    }

    public static function load_component_component(string $name, string $sub_folder = null): void
    {
        self::load_component_component_with_state($name, null, $sub_folder);
    }

    public static function load_site_component(string $name, string $sub_folder = null): void
    {
        self::load_site_component_with_state($name, null, $sub_folder);
    }

    public static function load_page_component(string $name, string $sub_folder = null): void
    {
        self::load_page_component_with_state($name, null, $sub_folder);
    }

    public static function load_loop_component(string $name, string $sub_folder = null): void
    {
        self::load_loop_component_with_state($name, null, $sub_folder);
    }

    public static function _do_load_xyz_component(array $folders, string $name, string $sub_folder = null, array $object_state = null): void
    {
        //Support an optional parameter for a single sub folder
        if ($sub_folder) {
            // Allow a path-separated list of even more folders
            $folders = array_merge($folders, explode(DIRECTORY_SEPARATOR, $sub_folder));
        }

        self::load_component_by_folder($name, $folders, $object_state);
    }

    public static function load_component_by_folder(string $name, array $folders, array $object_state = null): void
    {
        //Prepend the template directory on to the start of the array
        array_unshift($folders, \get_template_directory());

        // Allow callers to specify custom file extensions, such as .twig
        $file_extensions = ['.php'];
        if (function_exists('apply_filters')) {
            $file_extensions = apply_filters('vendi/component-loader/file-extensions', $file_extensions);
        }

        $paths = [];

        foreach ($file_extensions as $file_extension) {
            //Append the file name to the end of the array
            $folders[] = $name.$file_extension;

            //Merge into a giant path using the wonderful spread operator
            $path = Path::join(...$folders);

            $paths[] = $path;

            // If the file doesn't exist, move on to the next extension
            if (!is_readable($path)) {
                continue;
            }

            //This will hold a backup copy of the object state.
            //NOTE: If we aren't given an object state, we will intentionally be setting
            //the global state to null to avoid accidental usage which could lead to bad
            //programming practice.
            global $vendi_component_object_state;
            $backup_state = $vendi_component_object_state;

            // PHPStorm wants to elevate this to outside the loop, which is technically valid,
            // however we are keeping this close to the actual include on purpose to make it
            // more obvious (hopefully) how it is used.
            /** @noinspection DisconnectedForeachInstructionInspection */
            if ($object_state && count($object_state)) {
                $vendi_component_object_state = $object_state;
            } else {
                $vendi_component_object_state = null;
            }

            if (function_exists('do_action')) {
                if (function_exists('do_action_deprecated')) {
                    \do_action_deprecated('vendi/component-loaded/loading-template', [$name, $folders, $path], '2.0', 'The hook\'s namespace typo has been corrected to "component-loader"');
                }
                \do_action('vendi/component-loader/loading-template', $name, $folders, $path);
            }

            include $path;

            $vendi_component_object_state = $backup_state;

            return;
        }

        //Output debug code to help template people know what file to create
        echo "\n";
        $path = reset($paths);
        if (function_exists('do_action')) {
            if (function_exists('do_action_deprecated')) {
                \do_action_deprecated('vendi/component-loaded/missing-template', [$name, $folders, $path], '2.0', 'The hook\'s namespace typo has been corrected to "component-loader".');
            }
            \do_action('vendi/component-loaded/missing-template', $name, $folders, $path, $paths);
        }
        echo sprintf('<!-- Could not find template %1$s in folder(s) %2$s -->', \esc_html($name), \esc_html(implode('/', $folders)));
        echo "\n";
    }
}
