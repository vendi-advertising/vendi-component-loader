# Components
Vendi uses this library along with
the Advanced Custom Fields (ACF) Flexible Content Layouts system to manage individual components. Technically,
this library is actually completely unaware of ACF and there are actually cases where it is used to manage
WordPress sections, too.

## Global functions
The component loader exports several functions to the global namespace for ease of use when theming. The list of
global functions can be found by
[inspecting this file](https://github.com/vendi-advertising/vendi-component-loader/blob/master/includes/Functions.php),
but they all take the form of `vendi_load_XYZ_component` or `vendi_load_XYZ_component_with_state`, where `XYZ` can be
one of `loop`, `page`, `site` or `component`. (_Yes, this does mean that there's a function called
`vendi_load_component_component`, where consistency won out over awkward naming._);

## Folder location
All components must live in specially-named folders inside of a folder called `page-parts` that itself must live in
the theme's root folder. The specially-named folders are the same as listed in the *Global functions* section:
`loop`, `page`, `site` or `component`.

## Folder/component types
The four specially-named folders don't have any explicit uses, and the system will not break if you choose to not
follow the pattern outlined here. There are also times when a theme deviates from this pattern depending on how it was
built and how it evolved.

Generally speaking, these are the four folder types and their usage. See *Additional folder types* for further
customization.

  * `site`
    * The site folder is intended to hold "shell" content that is found on the bulk of pages such as header, footer,
      breadcrumbs and hero banners.
  * `page`
    * The page folder is intended to hold individual specific pages such as 404, search and front.
  * `loop`
    * The loop folder is very similar to the page folder but is intended to hold specific pages with WordPress loop
      code.
  * `component`
    * The component folder is generally used to hold ACF flexible content layouts, however it sometimes contains
      other component-like things that aren't controlled by ACF.

## Function parameters
### Template name
Each function takes as the first parameter the name of the template to load. The argument passes to this parameter
must not include the file extension. For instance, `vendi_load_page_component('404')` would load the file
`/page-parts/page/404.php`. This argument is required.

### Sub-folder
Each function takes an optional parameter allowing you to specify a sub-folder, relative to the type folder, to load
the template from. If you are using a state-based function (see *Components with state*), this is the third parameter,
otherwise it is the second.  For instance, `vendi_load_site_component('404', 'heros')` would load the file
`/page-parts/site/herps/404.php`.

### State
The functions that include `_with_state` in their name allow passing an array as the third parameter that will
be used to populate a global variable that exists only while that template is included. For instance,
`vendi_load_site_component_with_state('404', ['abc' => 'xyz'], 'heros')` would load the file
`/page-parts/site/herps/404.php` and populate a global array variable called `$vendi_component_object_state` with one
key of `abc` that had a value of `xyz`. See *Components with state* for more details.

## Components with state
Each global function has a version that includes an optional global state parameter which allows you to effectively
pass parameters into the included file. The value that you provide to the state parameter must be an array, and it will
be set on a global variable called `$vendi_component_object_state`. It is up to the template file itself to act on
this global variable, no implicit usage is otherwise built.

*NOTE*: The global variable `$vendi_component_object_state` should always be considered read-only, and it should never
be written to. Each template load always backs up the current global variable, includes the template, and then resets
the global variable to allow for nested calls. Because of this, writing directly to this variable will almost never
work as intended.

Generally speaking, the state versions of the functions are almost never used, and instead it is preferred to use
traditional `if` logic within the templates themselves. There are cases, however, where it is convenient to pass
arguments into the template to set default values, such as when a component is re-used but one version doesn't
have certain settings. For instance, a news listing component might allow customizations everywhere except the
home page, where the settings are baked into a template.

## Missing files
If a template cannot be found and/or read, an HTML comment is sent with the necessary information for debugging
purposes. The comment takes the form of:
`<!-- Count not file template [template name] in folder(s) [relative folder name] -->`.

There is no concept of stage/live/production/dev/etc., and this message is always emitted if a template cannot be read.

## Debugging & actions
The simplest way to debug is by looking for the HTML comment as mentioned in the *Missing files* section.

### Action: Loading template
Right before a template is loaded, the custom WordPress action `vendi/component-loaded/loading-template` is fired.
Since this is an action, you cannot stop the template loader, but you can at least log or inspect what it is about
to load.

This action receives three parameters, the template file name being loaded, the relative folder path for the template,
and the absolute path of the template file. It can be hooked into using:

```php
add_action(
    'vendi/component-loaded/loading-template',
    static function($name, $folders, $path) {
        // Do something here
    },
    10,
    3
);
```

An example of using this action is if you want to audit every page that a component is being loaded on. Please
contact Vendi if you would like a sample of code for that.

### Action: Missing template
If a template cannot be found, right before the HTML comment is emitted the custom WordPress action
`vendi/component-loaded/missing-template` is fired. Since this is an action, you cannot stop the HTML comment from
being emitted, but you can perform your own additional logic.

This action receives three parameters, the template file name being loaded, the relative folder path for the template,
and the absolute path of the template file. It can be hooked into using:

```php
add_action(
    'vendi/component-loaded/missing-template',
    static function($name, $folders, $path) {
        // Do something here
    },
    10,
    3
);
```

An example of using this action is if you want to automatically create the template files for newly created ACF
layouts, and pre-populate them with content making it obvious that further work needs to be done. We especially
recommend doing this during the early stages of development. Please contact Vendi if you would like a sample of code
for that.

## Additional folder types
For simplicity, this library only exposes four primary component types that are used on the majority of websites. If
you have another specific type that you would like to use, you can easily implement it by creating your own function
which calls the generic function `Vendi\Shared\WordPress\VendiComponentLoader::load_component_by_folder()`. This
function takes three arguments, the template name (required), an array of folders relative to the theme's root
directory (required), and any additional object state (optional).

*NOTE*: The second parameter is an array of sub-folders relative to the theme's root and does not by default include
the `page-parts` folder. To use that, include the argument `VendiComponentLoader::SHARED_PARENT_FOLDER` as the first
item in the array. You could also pass path-traversal parameters such as  `..` to break out of the theme's folder, but
make sure to *filter and sanitize* what you provide so that you don't introduce an exploit or leak private data!

*NOTE*: The component loader is meant as a way to organize code in a simple manner. Although it also allows further
folder customizations, we encourage developers to not over-think the organization until it actually provides a
specific benefit. Creating folders for the sake of creating folders might lead to a less-than-optimal developer
experience, especially when on-boarding new team members.

### Example
If you wanted to treat "videos" as a first-class type, you could create the following function:

```php
use Vendi\Shared\WordPress\VendiComponentLoader;

function YOUR_PREFIX_load_video_component(string $name)
{
    VendiComponentLoader::load_component_by_folder($name, [VendiComponentLoader::SHARED_PARENT_FOLDER, 'video']);
}
```

Which would load templates from `/page-parts/video/`.
