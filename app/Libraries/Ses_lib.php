<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package     CodeIgniter
 * @author      Hiren Vala
 * @copyright   Copyright (c) 2020, Hyvikk Solutions
 * @license    
 * @link        https://www.hyvikk.com
 * @since       Version 1.0
 * @filesource
 */
require_once 'vendor/autoload.php';
use Aws\Ses\SesClient;
use Aws\Exception\AwsException;

class Ses_lib {
    protected $CI;
    public function __construct($params = array()){
        $this->CI =& get_instance();
        $this->CI->load->helper('url');
    }

    public function send($sender, $receivers, $subject, $content){
		$config = $this->CI->config->item('ses_sdk');
		$SesClient = new SesClient([
		    'version' => 'latest',
		    'region'  => $config['region'],
		    'credentials' => [
				'key'    => $config['key'],
				'secret' => $config['secret'],
			],
		]);
		$sender_email = $sender;

		if(!is_array($receivers)){
			$receivers=[$receivers];
		}

		$recipient_emails = $receivers;
		$configuration_set = $config['config_set'];
		//$plaintext_body = 'This email was sent with Amazon SES using the AWS SDK for PHP.' ;
		$html_body =  $content;
		$char_set = 'UTF-8';

		try {
		    $result = $SesClient->sendEmail([
		        'Destination' => [
		            'ToAddresses' => $recipient_emails,
		        ],
		        'ReplyToAddresses' => [$sender_email],
		        'Source' => $sender_email,
		        'Message' => [
		          'Body' => [
		              'Html' => [
		                  'Charset' => $char_set,
		                  'Data' => $html_body,
		              ],
		              // 'Text' => [
		              //     'Charset' => $char_set,
		              //     'Data' => $plaintext_body,
		              // ],
		          ],
		          'Subject' => [
		              'Charset' => $char_set,
		              'Data' => $subject,
		          ],
		        ],
		        // If you aren't using a configuration set, comment or delete the
		        // following line
		        'ConfigurationSetName' => $configuration_set,
		    ]);
		    $messageId = $result['MessageId'];
		    // echo("Email sent! Message ID: $messageId"."\n");
		} catch (AwsException $e) {
		    // output error message if fails
		    log_message('error', "The email was not sent. Error message: ".$e->getAwsErrorMessage()."\n Subject: ". $subject);
			// echo $e->getMessage();
			// echo("The email was not sent. Error message: ".$e->getAwsErrorMessage()."\n");
			// echo "\n";
		}
    }
}