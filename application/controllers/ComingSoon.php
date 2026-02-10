<?
defined('BASEPATH') OR exit('No direct script access allowed');

class Comingsoon extends CI_Controller{

	public function __construct()
	{
	    parent::__construct();

	    if(1){
	        $this->load->view('comingsoon');
	        die();
	    }
	}
}
?>