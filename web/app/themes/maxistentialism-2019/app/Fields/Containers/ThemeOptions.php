<?php
/**
 * Containers: Theme Options
 *
 * @package brightbrightgreat/maxistentialism-2019
 * @author  Bright Bright Great <sayhello@brightbrightgreat.com>
 */

namespace App\Fields\Containers;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

class ThemeOptions
{
	public function __construct()
	{
		Container::make( 'theme_options', 'Theme Options' )
			->add_tab( __( 'Social Media' ), array(
				Field::make( 'text', 'facebook', __( 'Facebook' ) ),
				Field::make( 'text', 'twitter', __( 'Twitter' ) ),
				Field::make( 'text', 'instagram', __( 'Instagram' ) ),
				Field::make( 'text', 'linkedin', __( 'Linkedin' ) ),
			) )

			->add_tab( __( 'Contact Info' ), array(
				Field::make( 'text', 'email', __( 'Email' ) ),
				Field::make( 'text', 'phone', __( 'Phone' ) ),
				Field::make( 'text', 'street_address', __( 'Street Address' ) ),
				Field::make( 'text', 'city_state_zip', __( 'City, State Zip' ) ),
			))

			->add_tab( __( 'Mailchimp Info' ), array(
				Field::make( 'text', 'api_key', __( 'API Key' ) ),
				Field::make( 'text', 'list_id', __( 'Audience/List ID' ) ),
			));
	}
}
