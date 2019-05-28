<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'vendor/autoload.php';
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\S3\MultipartUploader;
use Aws\Exception\MultipartUploadException;

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
//		$this->load->view('welcome_message');
        $s3Client = new S3Client(array(
            'region' => 'ap-south-1',
            'version' => 'latest',
            'credentials' => array(
                'key' => 'YOUR_KEY',
                'secret' => 'YOUR_SECRET',
            ),
        ));
        $source = 'C:\Users\sz\Pictures\Screenshots\test111.png';
        $uploader = new MultipartUploader($s3Client, $source, array(
            'bucket' => 'BUCKET_NAME',
            'key' => 'NAME_TO_BE_STORED_IN_AWS',
            'acl' => 'public-read',/*permission*/
        ));


        try {
            $result = $uploader->upload();
            echo "Upload complete: {$result['ObjectURL']}\n";
        } catch (MultipartUploadException $e) {
            echo $e->getMessage() . "\n";
        }



	}
}
