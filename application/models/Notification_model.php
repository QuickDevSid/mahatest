<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Firebase\JWT\JWT;

class Notification_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function send_app_notification($device_token,$title,$message,$data) {
		$client = new Client();

		$serviceAccountPath = 'mahatest-816de-caee3884be2a.json';

		$jsonKey = json_decode(file_get_contents($serviceAccountPath), true);
		$jwt = $this->generate_jwt($jsonKey);

		$url = 'https://fcm.googleapis.com/v1/projects/mahatest-816de/messages:send';
		
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
    public function test_notification() {
		$client = new Client();
		$title = 'Hello Saurav...';
		$message = 'Have u received notification';
        $serviceAccountPath = 'mahatest-816de-caee3884be2a.json';
		
		$device_token = 'cmOk3Z_RTYiLK37UlN5tWw:APA91bGLQPv1JHhOly_7tH5NSmKP-qmkvmc52lNMsgs--epvanZqkbXsT_AK71H4ZdI6SDOz-zhI-KpGQsXK3EVZz2oNIrACk7MyDCfDjyfkTqOyDy6T8wE';

        $jsonKey = json_decode(file_get_contents($serviceAccountPath), true);
        $jwt = $this->generate_jwt($jsonKey);

        $url = 'https://fcm.googleapis.com/v1/projects/mahatest-816de/messages:send';
        
        $body = [
			"message" => [
				"token" => $device_token,
				"notification" => [
					"title" => $title,
					"body" => $message,
				],
				"data" => [
					"landing_page" => 'my_contents',
					"redirect_id" => ''
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

        //    echo json_encode(
        //     array(
        //         "notification" => json_encode([
		// 			"title" => $title,
		// 			"body" => $message,
		// 		]),
        //         'google_response'   =>  $response->getBody()
        //     )
        //    );
        } catch (RequestException $e) {
           echo 'Error: ' . $e->getMessage();
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
    
	public function send_notification($app_message,$title,$notification_data,$type,$user_id){
        $this->db->where('login_id',$user_id);
        $exist = $this->db->get('user_login')->row();
        if(!empty($exist) && $exist->fcm_token != ""){
            $notification_response = $this->send_app_notification($exist->fcm_token,$title,$app_message,$notification_data);		
            $data = array(
                'type'		    =>	$type,
                'send_customer' =>	$user_id,
                'title'		    =>	$title,
                'content'		=>	$app_message,
                'notification_data'		=>	$notification_data != "" && is_array($notification_data) && !empty($notification_data) ? json_encode($notification_data) : '',
                'api_response_status'	=>	'',
                'api_response'	=>	$notification_response,
                'created_on'	=>	date('Y-m-d H:i:s'),
            );
            $this->db->insert('tbl_customer_notifications',$data);
        }
	}

}