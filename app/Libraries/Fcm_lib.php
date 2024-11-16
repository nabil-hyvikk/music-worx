<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * @package     CodeIgniter FCM v1
 * @author      Hiren Vala
 * @copyright   Copyright (c) 2024, Hyvikk Solutions
 * @license    
 * @link        https://www.hyvikk.com
 * @since       Version 1.0
 * @filesource
 */
require_once 'vendor/autoload.php';
use Google\Client;

class Fcm_lib {
    protected $CI;
    public $project_id;
    public $json;
    public function __construct($params = array()){
        $this->CI =& get_instance();
        $this->CI->load->helper('url');
        $this->project_id='music-worx-e83c5';
        $this->json=realpath('youtubeapi/music-worx-e83c5-firebase-adminsdk-hkouz-996f30cf56.json');
    }

    public function push($tokens, $title, $body, $image='', $link=''){
		if($image==''){
			$image=DEFAULT_IMAGE;
		}
		if($link==''){
			$image=FRONTEND;
		}
		$payload_data = [
			// 'tokens'=>$tokens,
			'title'=>$title,
			'body'=>$body,
			'image'=>$image,
			'link'=>$link
		];
		try {
			$accessToken = $this->getAccessToken($this->json);
			foreach ($tokens as $key => $single) {				
				$payload=$this->prepare_payload($payload_data, $single);
				$response = $this->sendMessage($accessToken, $this->project_id, $payload);
				echo "\n".'FCM notification sent: ' . print_r($response, true)."\n";
			}
		} catch (Exception $e) {
			echo $e->getMessage();
			log_message('error', "FCM: push failed | ".$e->getMessage());
		}
    }

    private function prepare_payload($msg_data, $device_id){
    	$default_title="Music Worx";
		$default_body="Checkout new music on Music Worx";
		
    	// Prepare payload for FCM v1
		$payload = [
		    'message' => [
		        'token' => $device_id,  // Or 'tokens' if sending to multiple devices
		        'notification' => [
		            'title' => $msg_data['title'] ?? $default_title,
		            'body' => $msg_data['body'] ?? $default_body,
		            'image' => $msg_data['image'] ?? null
		        ],
		        'data'=>[
		        	'title' => $msg_data['title'] ?? $default_title,
		            'body' => $msg_data['body'] ?? $default_body,
		            'image' => $msg_data['image'] ?? null
		        ],
		        'android' => [
		        	'priority'=>'high',
		            // 'notification' => [
		            //     'image' => $msg_data['image'] ?? null,
		            //     'icon' => $msg_data['image'] ?? null,
		            //     'click_action' => $msg_data['link']
		            // ]
		        ],
		        'webpush' => [
		            'notification' => [
		                'image' => $msg_data['image'] ?? null,
		                'click_action' => $msg_data['link']
		            ]
		        ],
		        'apns' => [
		            'payload' => [
		                'aps' => [
		                    'category' => $msg_data['link'],
		                    'mutable-content' => 1,  // Needed for displaying image in iOS
		                    'alert' => [
		                        'title' => $msg_data['title'] ?? $default_title,
		                        'body' => $msg_data['body'] ?? $default_body
		                    ]
		                ]
		            ],
		            'fcm_options' => [
		                'image' => $msg_data['image'] ?? null
		            ]
		        ]
		    ]
		];
		return $payload;
    }

    public function generate_access_token(){
    	return $this->getAccessToken($this->json);
    }

	private function getAccessToken($serviceAccountPath) {
		$client = new Client();
		$client->setAuthConfig($serviceAccountPath);
		$client->addScope('https://www.googleapis.com/auth/firebase.messaging');
		$client->useApplicationDefaultCredentials();
		$token = $client->fetchAccessTokenWithAssertion();
		return $token['access_token'];
	}

	private function sendMessage($accessToken, $projectId, $payload) {
		$url = 'https://fcm.googleapis.com/v1/projects/' . $projectId . '/messages:send';
		$headers = [
			'Authorization: Bearer ' . $accessToken,
			'Content-Type: application/json',
		];

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
		$response = curl_exec($ch);
		if ($response === false) {
			throw new Exception('Curl error: ' . curl_error($ch));
		}
		curl_close($ch);
		return json_decode($response, true);
	}

	// Function to subscribe devices to a topic
	function subscribeToTopic($accessToken, $topic, $registrationTokens) {
	    $url = 'https://iid.googleapis.com/iid/v1:batchAdd';

	    $data = [
	        'to' => '/topics/' . $topic,
	        'registration_tokens' => $registrationTokens
	    ];

	    $headers = [
	        'Authorization: Bearer ' . $accessToken,
	        'Content-Type: application/json'
	    ];

	    $ch = curl_init($url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_POST, true);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
	    
	    $response = curl_exec($ch);
	    if ($response === false) {
	        echo 'Curl error: ' . curl_error($ch);
	    } else {
	        echo 'Response: ' . $response;
	    }
	    
	    curl_close($ch);
	}

	// Function to unsubscribe devices from a topic (cleanup)
	function unsubscribeFromTopic($accessToken, $topic, $registrationTokens) {
	    $url = 'https://iid.googleapis.com/iid/v1:batchRemove';

	    $data = [
	        'to' => '/topics/' . $topic,
	        'registration_tokens' => $registrationTokens
	    ];

	    $headers = [
	        'Authorization: Bearer ' . $accessToken,
	        'Content-Type: application/json'
	    ];

	    $ch = curl_init($url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_POST, true);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

	    $response = curl_exec($ch);
	    if ($response === false) {
	        echo 'Curl error: ' . curl_error($ch);
	    } else {
	        echo 'Response: ' . $response;
	    }

	    curl_close($ch);
	}

}