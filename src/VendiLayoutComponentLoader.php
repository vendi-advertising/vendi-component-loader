<?php

declare(strict_types=1);

namespace Vendi\Shared\WordPress\ComponentLoader;

use Symfony\Component\Filesystem\Path;

final class VendiLayoutComponentLoader
{
    public const SHARED_LAYOUT_FOLDER = 'layouts';

    public static function load_layout_based_sub_component(string $layout, string $subComponentName): void
    {
        self::load_layout_based_component_with_state([$layout, 'layouts', $subComponentName], null);
    }

    public static function load_layout_based_component(string $layout): void
    {
        self::load_layout_based_component_with_state($layout, null);
    }

    public static function load_layout_based_component_with_state(string|array $layout, array $object_state = null): void
    {
        $localName = is_string($layout) ? [$layout] : $layout;

        $componentDirectory = Path::join(get_template_directory(), self::SHARED_LAYOUT_FOLDER, ...$localName);
        $componentFile = Path::join($componentDirectory, 'component.php');
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

        //Output debug code to help template people know what file to create
        echo "\n";
        if (function_exists('do_action')) {
            do_action('vendi/component-loader/missing-layout', $localName);
        }
        echo sprintf('<!-- Could not find layout %1$s -->', esc_html($localName));
        echo "\n";
    }
}