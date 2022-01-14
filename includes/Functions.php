<?php

declare(strict_types=1);

use Vendi\Shared\WordPress\ComponentLoader\VendiComponentLoader;

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
