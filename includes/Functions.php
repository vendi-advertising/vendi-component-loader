<?php

declare(strict_types=1);

use JetBrains\PhpStorm\Deprecated;
use Vendi\Shared\WordPress\ComponentLoader\VendiComponentLoader;
use Vendi\Shared\WordPress\ComponentLoader\VendiLayoutComponentLoader;

#[Deprecated('Use load_layout_based_component_with_state with an array')]
function vendi_load_layout_based_sub_component_with_state(string $layout, string $subComponentName, ?array $object_state = null): void
{
    VendiLayoutComponentLoader::load_layout_based_component_with_state([$subComponentName, $layout], $object_state);
}

#[Deprecated('Use vendi_load_layout_based_component with an array')]
function vendi_load_layout_based_sub_component(string $layout, string $subComponentName): void
{
    VendiLayoutComponentLoader::load_layout_based_component_with_state([$subComponentName, $layout], null);
}

function vendi_load_layout_based_component(string|array $layout): void
{
    VendiLayoutComponentLoader::load_layout_based_component_with_state($layout, null);
}

function vendi_load_layout_based_component_with_state(string|array $layout, array $object_state): void
{
    VendiLayoutComponentLoader::load_layout_based_component_with_state($layout, $object_state);
}

function vendi_load_sub_component_with_state(string $name, array $object_state, string $sub_folder = null): void
{
    VendiComponentLoader::load_sub_component_with_state($name, $object_state, $sub_folder);
}

function vendi_load_component_component_with_state(string $name, array $object_state, string $sub_folder = null): void
{
    VendiComponentLoader::load_component_component_with_state($name, $object_state, $sub_folder);
}

function vendi_load_loop_component_with_state(string $name, array $object_state, string $sub_folder = null): void
{
    VendiComponentLoader::load_loop_component_with_state($name, $object_state, $sub_folder);
}

function vendi_load_site_component_with_state(string $name, array $object_state, string $sub_folder = null): void
{
    VendiComponentLoader::load_site_component_with_state($name, $object_state, $sub_folder);
}

function vendi_load_page_component_with_state(string $name, array $object_state, string $sub_folder = null): void
{
    VendiComponentLoader::load_page_component_with_state($name, $object_state, $sub_folder);
}

function vendi_load_component_component(string $name, string $sub_folder = null): void
{
    VendiComponentLoader::load_component_component($name, $sub_folder);
}

function vendi_load_loop_component(string $name, string $sub_folder = null): void
{
    VendiComponentLoader::load_loop_component($name, $sub_folder);
}

function vendi_load_site_component(string $name, string $sub_folder = null): void
{
    VendiComponentLoader::load_site_component($name, $sub_folder);
}

function vendi_load_page_sub_component(string $name, string $sub_folder): void
{
    VendiComponentLoader::load_page_component($name, $sub_folder);
}

function vendi_load_page_component(string $name, string $sub_folder = null): void
{
    VendiComponentLoader::load_page_component($name, $sub_folder);
}

/**
 * @param string $name
 * @return void
 * @deprecated Please move this function into your theme because it will be removed in a future version.
 */
function vendi_load_resource_component(string $name): void
{
    VendiComponentLoader::load_component_by_folder($name, [VendiComponentLoader::SHARED_PARENT_FOLDER, 'resources']);
}
