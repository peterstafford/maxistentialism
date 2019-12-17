<?php

/**
 * Controllers: Subscribers
 *
 * @package brightbrightgreat/maxistentialism-2019
 * @author  Bright Bright Great <sayhello@brightbrightgreat.com>
 */

namespace App\Controllers\Api;

use WP_REST_Request;
use WP_REST_Response;

class SubscribersController
{
	public function store(WP_REST_Request $request)
	{

		$Mailchimp = new \App\Mailchimp();
		$response = $Mailchimp->subscribe(
			sanitize_email($request['email']),
			$request['first_name'],
			$request['city']
		);

		if ( !isset($response['status']) || $response['status'] !== 'subscribed' ) {
			return new WP_REST_Response([
				'message' => $response,
				'success' => false
			], 400);
		}

		return new WP_REST_Response([
			'message' => "Subscription created successfully!",
			'success' => true
		], 200);
	}
}
