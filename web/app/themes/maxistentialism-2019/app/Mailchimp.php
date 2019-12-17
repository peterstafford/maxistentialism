<?php

namespace App;
use \DrewM\MailChimp\MailChimp as MC;

class Mailchimp {

	public $api;
	public $list_id;

	public function __construct() {
		$this->api = new MC(carbon_get_theme_option('api_key'));
		$this->list_id = carbon_get_theme_option('list_id');
	}

	public function subscribe($email, $name, $city) {
		$merge_fields = array(
			'FNAME'=>$name,
		);
		if ($city) {
			$merge_fields['ADDRESS'] = array(
				'addr1' => ' - ',
				'city' => 'Chicago',
				'state' => 'Illinois',
				'zip' => '60602',
			);
		}

		return $this->api->post("lists/$this->list_id/members", [
			'email_address'=>$email,
			'status'=>'subscribed',
			'merge_fields'=>$merge_fields,
		]);
	}

	public function unsubscribe($email) {
		$subscriber_hash = $this->api->subscriberHash($email);

		return $this->api->delete("lists/$this->list_id/members/$subscriber_hash");
	}

}
