<?php

declare(strict_types=1);

namespace Vendi\Shared\WordPress\ComponentLoader;

use Symfony\Component\Filesystem\Path;

final class VendiLayoutComponentLoader
{
    private const SHARED_LAYOUT_FOLDER_DEFAULT = 'layouts';

    private static function get_layout_folder(): string
    {
        static $folder = null;
        if (!$folder) {
            $folder = self::SHARED_LAYOUT_FOLDER_DEFAULT;
            if (function_exists('apply_filters')) {
                $folder = apply_filters('vendi/component-loader/get-layout-folder', $folder);
            }
        }

        return $folder;
    }

    public static function load_layout_based_component_with_state(string|array $layout, ?array $object_state = null): void
    {
        $localName = is_string($layout) ? explode('/', $layout) : $layout;

        // Remove blanks, just in case
        $localName = array_filter($localName);

        $componentDirectory = Path::join(get_template_directory(), self::get_layout_folder(), ...$localName);

        $lastFolder = basename($componentDirectory);

        $filesToTest = [$lastFolder.'.php'];

        foreach ($filesToTest as $fileToTest) {
            $componentFile = Path::join($componentDirectory, $fileToTest);
            if (is_readable($componentFile)) {
                global $vendi_layout_component_object_state;
                $backup_state = $vendi_layout_component_object_state;

                if ($object_state && count($object_state)) {
                    $vendi_layout_component_object_state = $object_state;
                } else {
                    $vendi_layout_component_object_state = null;
                }

                if (function_exists('do_action')) {
                    do_action('vendi/component-loader/loading-layout', $localName);
                }

                include $componentFile;

                $vendi_layout_component_object_state = $backup_state;

                return;
            }
        }

        //Output debug code to help template people know what file to create
        echo "\n";
        if (function_exists('do_action')) {
            do_action('vendi/component-loader/missing-layout', $localName);
        }
        echo sprintf('<!-- Could not find layout %1$s -->', esc_html($localName));
        echo "\n";
    }
}