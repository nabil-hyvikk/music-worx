<?php
namespace App\Libraries;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


//if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * @package     CodeIgniter
 * @author      Hiren Vala
 * @copyright   Copyright (c) 2020, Hyvikk Solutions
 * @license
 * @link        https://www.hyvikk.com
 * @since       Version 1.0
 * @filesource
 */
///require_once 'vendor/autoload.php';
use Aws\S3\S3Client;
use DateTime;
use Kraken;

class Kraken_lib
{
    protected $CI;
    public function __construct($params = array())
    {
        // $this->CI =& get_instance();
        // $this->CI->load->helper('url');
    }

    public function optimize_and_upload($file_path, $file_name, $bucket_folder, $resize = 0, $waveform = 0)
    {
        $data = array();
        if ($waveform == 0) {
            $data[] = $this->perform($file_path, $file_name, $bucket_folder, 500, 500);
        } else {
            $data[] = $this->perform($file_path, $file_name, $bucket_folder);
        }

        if ($resize) {
            $file_nm = pathinfo($file_name);
            $file_name1 = $file_nm['filename'] . "-250x250.jpg";
            $file_name2 = $file_nm['filename'] . "-100x100.jpg";
            $data[] = $this->perform($file_path, $file_name1, $bucket_folder, 250, 250);
            $data[] = $this->perform($file_path, $file_name2, $bucket_folder, 100, 100);
        }
        return $data;
    }

    public function optimized_upload($file_path, $bucket_folder)
    {
        $pathinfo = pathinfo($file_path);
        $data = array();
        $data[] = $this->perform($file_path, $pathinfo['basename'], $bucket_folder);
        return $data;
    }

    public function perform($file_path, $file_name, $bucket_folder, $width = 0, $height = 0)
    {
        //require_once APPPATH."third_party/lib/Kraken.php";
        //$kraken_conf=$this->CI->config->item('kraken');
        //$s3_conf=$this->CI->config->item('s3');
        //env('KRAKEN_API_KEY'), env('KRAKEN_API_SECRET')
        $kraken = new Kraken(env('KRAKEN_API_KEY'), env('KRAKEN_API_SECRET'));
        $datetime = new DateTime('01 Mar 2018');
        $expires = $datetime->format('c');
        $params = array(
            "file" => $file_path,
            "wait" => true,
            "lossy" => true,
            // "s3_store" => array(
            // 	"key" => $s3_conf['key'],
            // 	"secret" => $s3_conf['secret'],
            // 	"bucket" => "musicworx-pics",
            // 	"path" => $bucket_folder."/".$file_name,
            // 	"headers" => array(
            // 		"Cache-Control" => "max-age=31536000",
            // 		"Expires" => strtotime($expires),
            // 	),
            // 	"region" => $s3_conf['region'],
            // 	"webp" => true,
            // ),
        );
        if ($width != 0 && $height != 0) {
            $params["resize"] = array(
                "width" => $width,
                "height" => $height,
                "strategy" => "exact",
            );
        }

        $data = $kraken->upload($params);
        //var_dump($data);
        // Upload to Bucket
        if (isset($data['kraked_url'])) {
            $path = parse_url($data['kraked_url'], PHP_URL_PATH);
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            // $imgfile = realpath("uploads/covers") . '/' . uniqid() . '.' . $ext;
            // file_put_contents($imgfile, file_get_contents($data['kraked_url']));
            // $this->upload_to_wasabi($imgfile, $file_name, $bucket_folder);
            $imgfile = 'uploads/covers/' . uniqid() . '.' . $ext;
            Storage::disk('public')->put($imgfile, file_get_contents($data['kraked_url']));
            $imgfilePath = storage_path('app/public/' . $imgfile);
            $this->upload_to_wasabi($imgfilePath, $file_name, $bucket_folder);

            if (file_exists($imgfilePath)) {
                unlink($imgfilePath);
            } else {
                Log::error("File not found for deletion: {$imgfilePath}");
            }
        } else {
            // log_message('error', "Kraken: no url returned from kraken for file=>" . $file_name);
            //log_message('error', 'Kraken Dataset: ' . json_encode($data));
            if ($width != 0 && $height != 0) {
                $ext = pathinfo($file_path, PATHINFO_EXTENSION);
                $imgfile = realpath("./uploads/covers") . '/' . uniqid() . '.' . $ext;
                exec("convert \"" . $file_path . "\" -resize " . $width . "x" . $height . "! " . $imgfile);
                $this->upload_to_wasabi($imgfile, $file_name, $bucket_folder);
                unlink($imgfile);
                //log_message('error', 'Tried to upload with server resize');
            } else {
                $this->upload_to_wasabi($file_path, $file_name, $bucket_folder);
                // log_message('error', 'Tried to upload directly');
            }
        }
        return $data;
    }

    private function upload_to_wasabi($file_path, $file_name, $folder)
    {
        //$wasabi=$this->CI->config->item('wasabi');
        // $pathinfo=pathinfo($file);
        $s3 = S3Client::factory([
            'version' => 'latest',
            'endpoint' => env('WAS_URL'),
            'region' => env('WAS_DEFAULT_REGION'),
            'credentials' => [
                'key' => env('WAS_ACCESS_KEY_ID'),
                'secret' => env('WAS_SECRET_ACCESS_KEY'),
            ],
        ]);
        try {
            // Upload to S3
            $s3->putObject([

                'Bucket' => env('img_bucket'),
                'Key' => $folder . '/' . $file_name, // folder/file_Name.ext
                'Body' => fopen($file_path, 'r'),
                'ACL' => 'public-read',
            ]);
            $s3->waitUntil('ObjectExists', array(
                'Bucket' => env('img_bucket'),
                'Key' => $folder . '/' . $file_name,
            ));
        } catch (Aws\S3\Exception\S3Exception $e) {
            log_message('error', 'S3 Upload - ' . $e->getMessage());
        }
    }

}
