<?php

class Dmbfunctions {

    protected $CI;

    // We'll use a constructor, as you can't directly call a function
    // from a property definition.
    public function __construct()
    {
            // Assign the CodeIgniter super-object
            $this->CI =& get_instance();
    }

    public function loadGets()
    {
            $this->CI->load->helper('url');
            if(isset($_GET['video'])){
                if($_GET['video']==1){
                    $this->CI->session->set_userdata('content_type', 'videos');
                }
            }
            if(isset($_GET['audio'])){
                if($_GET['audio']==1){
                    $this->CI->session->set_userdata('content_type', 'audios');
                }
            }
            //echo $this->CI->session->userdata('content_type');
            //redirect();
    }

}
?>