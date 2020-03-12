<?php

declare(strict_types=1);

use Vendi\Shared\WordPress\VendiComponentLoader;

function vendi_load_component_component_with_state(string $name, array $object_state, string $sub_folder = null)
{
    VendiComponentLoader::load_component_component_with_state($name, $object_state, $sub_folder);
}

function vendi_load_loop_component_with_state(string $name, array $object_state, string $sub_folder = null)
{
    VendiComponentLoader::load_loop_component_with_state($name, $object_state, $sub_folder);
}

function vendi_load_site_component_with_state(string $name, array $object_state, string $sub_folder = null)
{
    VendiComponentLoader::load_site_component_with_state($name, $object_state, $sub_folder);
}

function vendi_load_page_component_with_state(string $name, array $object_state, string $sub_folder = null)
{
    VendiComponentLoader::load_page_component_with_state($name, $object_state, $sub_folder);
}

function vendi_load_component_component(string $name, string $sub_folder = null)
{
    VendiComponentLoader::load_component_component($name, $sub_folder);
}

function vendi_load_loop_component(string $name, string $sub_folder = null)
{
    VendiComponentLoader::load_loop_component($name, $sub_folder);
}

function vendi_load_site_component(string $name, string $sub_folder = null)
{
    VendiComponentLoader::load_site_component($name, $sub_folder);
}

function vendi_load_page_sub_component(string $name, string $sub_folder)
{
    VendiComponentLoader::load_page_component($name, $sub_folder);
}

function vendi_load_page_component(string $name, string $sub_folder = null)
{
    VendiComponentLoader::load_page_component($name, $sub_folder);
}

function vendi_load_resource_component(string $name)
{
    VendiComponentLoader::load_component_by_folder($name, [VendiComponentLoader::SHARED_PARENT_FOLDER, 'resources']);
}
