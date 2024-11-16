<?php
namespace App\Libraries;
//if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
//require_once 'vendor/autoload.php';
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use Aws\Exception\AwsException;
use Aws\Exception\MultipartUploadException;
use Aws\S3\MultipartUploader;
use Illuminate\Support\Facades\Log;

class Cloud_lib {
    protected $CI;
    public function __construct($params = array()){
        //$this->CI =& get_instance();
       // $this->CI->load->helper('url');
    }

    public function upload_to_wasabi($file, $bucket, $folder){
		//$wasabi=$this->CI->config->item('wasabi');
        //$wasabi = config('wasabi.key');
		$pathinfo=pathinfo($file);
		//$s3 = $this->wasabi_config(wasabi['endpoint'], $wasabi['region'], $wasabi['key'], $wasabi['secret']);
        $s3 = $this->wasabi_config(env('WAS_URL'), env('WAS_DEFAULT_REGION'), env('WAS_ACCESS_KEY_ID'), env('WAS_SECRET_ACCESS_KEY'));
		if(filesize(realpath($file)) > 5 * 1024 * 1024 * 1024){
			// User Multi-part uploaded if filesize greater than 5GB
		    try {
		        $uploader = new MultipartUploader($s3, $file, [
		            'bucket' => env($bucket),
		            'key' => $folder.'/'.$pathinfo['basename'],
		        ]);
		        $uploader->upload();
		    } catch (MultipartUploadException $e) {
		        \Log::error( 'S3 Multi-part Upload - '.$e->getMessage());
		    }
		}else{
			// Normal upload
			try {
				// Upload to wasabi
				$s3->putObject([
					'Bucket' => env($bucket),
					'Key'    => $folder.'/'.$pathinfo['basename'],
					'Body'   => fopen( $file, 'r'),
					// 'ACL'    => 'public-read',
				]);
				$s3->waitUntil('ObjectExists', array(
				    'Bucket' => env($bucket),
					'Key'    => $folder.'/'.$pathinfo['basename'],
				));
			} catch (S3Exception $e) {
				//\Log::error( 'S3 Upload - '.$e->getMessage());
                \Log::error('S3 Upload - ' . $e->getMessage());
			}
		}
	}

	public function public_upload($filepath, $filename, $bucket, $folder){
		//$wasabi=$this->CI->config->item('wasabi');
		//$s3 = $this->wasabi_config($wasabi['endpoint'], $wasabi['region'], $wasabi['key'], $wasabi['secret']);
        $s3 = $this->wasabi_config(env('WAS_URL'), env('WAS_DEFAULT_REGION'), env('WAS_ACCESS_KEY_ID'), env('WAS_SECRET_ACCESS_KEY'));
		try {
			// Upload to wasabi
			$s3->putObject([
				'Bucket' => env($bucket),
				'Key'    => $folder.'/'.$filename, // folder/file_Name.ext
				'Body'   => fopen( $filepath, 'r'),
				'ACL'    => 'public-read',
			]);
		} catch (S3Exception $e) {
			//\Log::error( 'S3 Upload - '.$e->getMessage());
		}
	}

	public function remove_from_wasabi($file_name, $bucket, $folder){
		//$wasabi=$this->CI->config->item('wasabi');
		//$s3 = $this->wasabi_config($wasabi['endpoint'], $wasabi['region'], $wasabi['key'], $wasabi['secret']);
        $s3 = $this->wasabi_config(env('WAS_URL'), env('WAS_DEFAULT_REGION'), env('WAS_ACCESS_KEY_ID'), env('WAS_SECRET_ACCESS_KEY'));
		try {
			// Remove from wasabi
			 $s3->deleteObject([
				'Bucket' => env($bucket),
				'Key'    => $folder.'/'.$file_name, // folder/file_Name.ext
			]);
		} catch (S3Exception $e) {
			echo "error";
            Log::info('deletion failed');
			//\Log::error( 'S3 Upload - '.$e->getMessage());
		}
	}

	public function copy_object_wasabi($new_name, $old_name, $bucket, $folder){
		//$wasabi=$this->CI->config->item('wasabi');
		//$s3 = $this->wasabi_config($wasabi['endpoint'], $wasabi['region'], $wasabi['key'], $wasabi['secret']);
        $s3 = $this->wasabi_config(env('WAS_URL'), env('WAS_DEFAULT_REGION'), env('WAS_ACCESS_KEY_ID'), env('WAS_SECRET_ACCESS_KEY'));
		try {
			// Copy an object.
			$s3->copyObject(array(
				'Bucket'     => env($bucket),
				'Key'        => $folder.'/'.$new_name,
				'CopySource' => env($bucket).'/'.$folder.'/'.$old_name,
			));
		} catch (S3Exception $e) {
			echo $e->getMessage();
			\Log::error( 'S3 Copy Failed - '.$e->getMessage());
		}
	}

	public function get_signed_url($file,$bucket, $folder, $duration=null){
		// Get S3 Signed URL
		//$wasabi=$this->CI->config->item('wasabi');
        //$wasabi = config('Wasabi');

       // dd($wasabi);
		// $s3 = $this->wasabi_config($wasabi['endpoint'], $wasabi['region'], $wasabi['key'], $wasabi['secret']);
        $s3 = $this->wasabi_config(env('WAS_URL'), env('WAS_DEFAULT_REGION'), env('WAS_ACCESS_KEY_ID'), env('WAS_SECRET_ACCESS_KEY'));
		try{
			if($folder!=""){
				$cmd = $s3->getCommand('GetObject', [
					'Bucket' => env($bucket),
					'Key' => $folder.'/'.$file,
				]);
			}else{
				$cmd = $s3->getCommand('GetObject', [
					'Bucket' => env($bucket),
					'Key' => $file,
				]);
			}

			// $request = $s3->createPresignedRequest($cmd, '+1 minutes');
			// //$presignedUrl = (string) $request->getUri();
			// return $request->getRequestTarget();
			if($duration==null){
				// $duration='+2 days';
				$duration='+30 minute';
			}
			$request = $s3->createPresignedRequest($cmd, $duration);
			// return 'https://s3.eu-central-1.wasabisys.com/music.music-worx.com'.$request->getRequestTarget();

			$presignedUrl = (string) $request->getUri();
			// Ensure the URL uses HTTPS
	        if (parse_url($presignedUrl, PHP_URL_SCHEME) !== 'https') {
	            $presignedUrl = preg_replace("/^http:/i", "https:", $presignedUrl);
	        }

	        return $presignedUrl;

		} catch (S3Exception $e) {
			//\Log::error( 'S3 Upload - '.$e->getMessage());
		}
	}

	public function get_file($file,$bucket, $folder){
		//$wasabi=$this->CI->config->item('wasabi');
		//$s3 = $this->wasabi_config($wasabi['endpoint'], $wasabi['region'], $wasabi['key'], $wasabi['secret']);
        $s3 = $this->wasabi_config(env('WAS_URL'), env('WAS_DEFAULT_REGION'), env('WAS_ACCESS_KEY_ID'), env('WAS_SECRET_ACCESS_KEY'));
		try{
			if($folder!=""){
				$cmd = $s3->getObject([
					'Bucket' => env($bucket),
					'Key' => './'.$folder.'/'.$file,
				]);
			}else{
				$cmd = $s3->getObject([
					'Bucket' => env($bucket),
					'Key' => './'.$file,
				]);
			}

			return $cmd;
		} catch (S3Exception $e) {
			//\Log::error( 'S3 Upload - '.$e->getMessage());
		}
	}

	public function file_exists($file, $bucket, $folder){
		//$wasabi=$this->CI->config->item('wasabi');
		//$s3 = $this->wasabi_config($wasabi['endpoint'], $wasabi['region'], $wasabi['key'], $wasabi['secret']);
        $s3 = $this->wasabi_config(env('WAS_URL'), env('WAS_DEFAULT_REGION'), env('WAS_ACCESS_KEY_ID'), env('WAS_SECRET_ACCESS_KEY'));
		try{
			return $s3->doesObjectExist(env($bucket), $folder.'/'.$file);
		}catch (S3Exception $e){
			return true;
		}
	}

	public function get_bucket_policy($bucket){
		//$wasabi=$this->CI->config->item('wasabi');
		//$s3 = $this->wasabi_config($wasabi['endpoint'], $wasabi['region'], $wasabi['key'], $wasabi['secret']);

        $s3 = $this->wasabi_config(env('WAS_URL'), env('WAS_DEFAULT_REGION'), env('WAS_ACCESS_KEY_ID'), env('WAS_SECRET_ACCESS_KEY'));
		try {
			$resp = $s3->getBucketPolicy([
				'Bucket' => env($bucket),
			]);
			return (string) $resp->get('Policy');
		} catch (AwsException $e) {
			\Log::error( 'S3 Get Policy - '.$e->getMessage());
			return false;
		}
	}

	public function update_bucket_policy($bucket, $policy){
		//$wasabi=$this->CI->config->item('wasabi');
		//$s3 = $this->wasabi_config($wasabi['endpoint'], $wasabi['region'], $wasabi['key'], $wasabi['secret']);
        $s3 = $this->wasabi_config(env('WAS_URL'), env('WAS_DEFAULT_REGION'), env('WAS_ACCESS_KEY_ID'), env('WAS_SECRET_ACCESS_KEY'));

		try {
			$resp = $s3->putBucketPolicy([
				'Bucket' => env($bucket),
				'Policy' => $policy,
			]);
		} catch (AwsException $e) {
			\Log::error( 'S3 Update Policy - '.$e->getMessage());
		}
	}

	private function wasabi_config($endpoint, $region, $key, $secret){
		return S3Client::factory([
			'version' => 'latest',
			'endpoint' => $endpoint,
			'region' => $region,
			'credentials' => [
				'key' => $key,
				'secret' => $secret,
			],
			'scheme' => 'https'
		]);
	}

	// private function upload_to_s3($file, $folder){
	// 	$s3_conf=$this->CI->config->item('s3');
	// 	$pathinfo=pathinfo($file);
	// 	$s3 = new S3Client([
	// 		'profile' => 'default',
	// 		'version' => 'latest',
	// 		'region' => $s3_conf['region']
	// 	]);
	// 	try {
	// 		// Upload to S3
	// 		$s3->putObject([
	// 			'Bucket' => 'musicworx-mp3',
	// 			'Key'    => $folder.'/'.$pathinfo['basename'], // folder/file_Name.ext
	// 			'Body'   => fopen( $file, 'r'),
	// 			'ACL'    => 'public-read',
	// 		]);
	// 	} catch (S3Exception $e) {
	// 	}
	// }

}
