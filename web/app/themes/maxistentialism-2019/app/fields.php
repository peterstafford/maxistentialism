<?php
/**
 * Register Carbon Fields
 *
 * @package brightbrightgreat/maxistentialism-2019
 * @author  Bright Bright Great <sayhello@brightbrightgreat.com>
 */

namespace App;

use App\Fields\Containers\ThemeOptions;
use App\Fields\Containers\PostMeta;
use Carbon_Fields\Carbon_Fields;

add_action('carbon_fields_register_fields', function () {
	new ThemeOptions();
	new PostMeta();
});

add_action( 'after_setup_theme', function () {
	Carbon_Fields::boot();
});
