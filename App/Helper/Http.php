<?php

namespace App\Helper;

class Http {

	public static function request(): array {

		$inputJSON = file_get_contents('php://input');
		return json_decode($inputJSON, TRUE);
	}

	public static function response(array $response, $httpCode = 200): string {
		header("Content-Type: text/json", true, $httpCode);
		exit(json_encode($response));
	}
}