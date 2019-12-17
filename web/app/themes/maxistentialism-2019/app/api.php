<?php

/**
 * API Endpoints
 *
 * @package brightbrightgreat/maxistentialism-2019
 * @author  Bright Bright Great <sayhello@brightbrightgreat.com>
 */

namespace App;

use App\Controllers\Api\SubscribersController;

/**
 * Register API endpoints
 */
add_action('rest_api_init', function () {
	$namespace = 'maxistentialism-2019/v1';

	register_rest_route($namespace, '/subscribers', array(
		'methods' => 'POST',
		'callback' => array(new SubscribersController, 'store'),
		'args' => array(
			'email' => array(
				'required' => true,
				'type' => 'string',
				'format' => 'email'
			),
			'first_name' => array(
				'required' => true,
				'type' => 'string',
			),
			'city' => array(
				'required' => false,
				'type' => 'boolean',
			),
		)
	));
});
