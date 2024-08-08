<?php

declare(strict_types=1);

use Vendi\Shared\WordPress\ComponentLoader\VendiComponentLoader;
use Vendi\Shared\WordPress\ComponentLoader\VendiLayoutComponentLoader;

function vendi_load_layout_based_component(string|array $layout, ?array $object_state = null): void
{
    VendiLayoutComponentLoader::load_layout_based_component_with_state($layout, null);
}

function vendi_load_sub_component_with_state(string $name, ?array $object_state = null, ?string $sub_folder = null): void
{
    VendiComponentLoader::load_sub_component_with_state($name, $object_state, $sub_folder);
}

function vendi_load_component_component_with_state(string $name, ?array $object_state = null, ?string $sub_folder = null): void
{
    VendiComponentLoader::load_component_component_with_state($name, $object_state, $sub_folder);
}

function vendi_load_loop_component_with_state(string $name, ?array $object_state = null, ?string $sub_folder = null): void
{
    VendiComponentLoader::load_loop_component_with_state($name, $object_state, $sub_folder);
}

function vendi_load_site_component_with_state(string $name, ?array $object_state = null, ?string $sub_folder = null): void
{
    VendiComponentLoader::load_site_component_with_state($name, $object_state, $sub_folder);
}

function vendi_load_page_component_with_state(string $name, ?array $object_state = null, ?string $sub_folder = null): void
{
    VendiComponentLoader::load_page_component_with_state($name, $object_state, $sub_folder);
}

function vendi_load_component_component(string $name, ?string $sub_folder = null): void
{
    VendiComponentLoader::load_component_component($name, $sub_folder);
}

function vendi_load_loop_component(string $name, ?string $sub_folder = null): void
{
    VendiComponentLoader::load_loop_component($name, $sub_folder);
}

function vendi_load_site_component(string $name, ?string $sub_folder = null): void
{
    VendiComponentLoader::load_site_component($name, $sub_folder);
}

function vendi_load_page_sub_component(string $name, ?string $sub_folder): void
{
    VendiComponentLoader::load_page_component($name, $sub_folder);
}

function vendi_load_page_component(string $name, ?string $sub_folder = null): void
{
    VendiComponentLoader::load_page_component($name, $sub_folder);
}