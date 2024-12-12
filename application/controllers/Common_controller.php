<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
require 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Firebase\JWT\JWT;

class Common_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    
	public function test_notification() {
		$client = new Client();
		$title = 'Test Notification Title';
		$message = 'Description';
        $serviceAccountPath = 'ms-saloon-d57c7b983485.json';
		
		$device_token = 'f9GQ2s92T52jw1TQeVPp7V:APA91bHGkcyx-KwdG7MgkxnNFHeznPcebNroTr6yGC93UaZU4SM59dlHW1AsRIDhaUF6eXvf83jTg_IN1sxcljh9RBMBOaZBmkXOzlOUvK4ANMLaORfSnpGN4ke8ntLU4QOQ8Q6CDctV';

        $jsonKey = json_decode(file_get_contents($serviceAccountPath), true);
        $jwt = $this->generate_jwt($jsonKey);

        $url = 'https://fcm.googleapis.com/v1/projects/ms-saloon/messages:send';
        
        $body = [
			"message" => [
				"token" => $device_token,
				"notification" => [
					"title" => $title,
					"body" => $message,
				],
				"data" => [
					"landing_page" => '',
					"order_id" => ''
				]
			]
		];		

        try {
            $response = $client->post($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $jwt,
                    'Content-Type' => 'application/json'
                ],
                'json' => $body
            ]);
            
           echo $response->getBody();
        } catch (RequestException $e) {
           echo 'Error: ' . $e->getMessage();
        }
	}
	public function send_app_notification($device_token,$title,$message,$data) {
		$client = new Client();

		$serviceAccountPath = 'ms-saloon-d57c7b983485.json';

		$jsonKey = json_decode(file_get_contents($serviceAccountPath), true);
		$jwt = $this->generate_jwt($jsonKey);

		$url = 'https://fcm.googleapis.com/v1/projects/ms-saloon/messages:send';
		
		$body = [
			"message" => [
				"token" => $device_token,
				"notification" => [
					"title" => $title,
					"body" => urldecode(str_replace('%0a', '\n', $message)),
				],
				"data" => $data
			]
		];

		try {
			$response = $client->post($url, [
				'headers' => [
					'Authorization' => 'Bearer ' . $jwt,
					'Content-Type' => 'application/json',
				],
				'json' => $body,
			]);
			
			// Check if the response status code is in the 2xx range
			if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
				// echo "Notification sent successfully: " . $response->getBody();
				// return true;
				return "Notification sent successfully: " . $response->getBody();
			} else {
				// echo "Failed to send notification: " . $response->getBody();
				// return false;
				return "Failed to send notification: " . $response->getBody();
			}
		} catch (RequestException $e) {
			// Handle any errors that occur during the request
			if ($e->hasResponse()) {
				$errorResponse = $e->getResponse();
				// echo "Error occurred: " . $errorResponse->getBody();
				return "Error occurred: " . $errorResponse->getBody();
			} else {
				// echo "Error occurred: " . $e->getMessage();
				return "Error occurred: " . $e->getMessage();
			}
			// return false;
		}
	}

	private function generate_jwt($jsonKey) {
        $now_seconds = time();
        $payload = array(
            "iss" => $jsonKey['client_email'],
            "sub" => $jsonKey['client_email'],
            "aud" => "https://oauth2.googleapis.com/token",
            "iat" => $now_seconds,
            "exp" => $now_seconds + 3600,
            "scope" => "https://www.googleapis.com/auth/cloud-platform"
        );

        $jwt = JWT::encode($payload, $jsonKey['private_key'], 'RS256');

        $client = new Client();
        $response = $client->post('https://oauth2.googleapis.com/token', [
            'form_params' => [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $jwt
            ]
        ]);

        $accessToken = json_decode($response->getBody(), true);

        return $accessToken['access_token'];
    }
}
