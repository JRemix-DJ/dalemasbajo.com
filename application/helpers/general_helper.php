<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('get_cover_url')) {
    function get_cover_url($cover_field = null, $product_id = null) {
        $covers_dir = FCPATH . 'assets/uploads/covers/';

        if (!empty($cover_field)) {
            $filename = basename($cover_field);
            if (file_exists($covers_dir . $filename)) {
                return base_url('assets/uploads/covers/' . $filename);
            }
        }

        if (!empty($product_id) && is_numeric($product_id)) {
            $extensions = ['png', 'jpg', 'jpeg', 'webp'];
            foreach ($extensions as $ext) {
                if (file_exists($covers_dir . 'cover_' . $product_id . '.' . $ext)) {
                    return base_url('assets/uploads/covers/' . 'cover_' . $product_id . '.' . $ext);
                }
                if (file_exists($covers_dir . 'mp3_art_' . $product_id . '.' . $ext)) {
                    return base_url('assets/uploads/covers/' . 'mp3_art_' . $product_id . '.' . $ext);
                }
            }
        }

        return base_url('assets/front/img/default-image.jpg');
    }
}

if (!function_exists('audio'))
{
	function audio($action){
		$productos_array=array(
			'CodDj',
			'Song',
			'Duration',
			'bpm',
			'Size',
			'UrlFile',
			'Aprobado',
			'UrlMuestra',
			'Fecha',
			'Type_price',
			'Artist',
			'Cover',
			'genre',
			'Bitrate',
			'hot',
			'new'
		);
		$productos_data=array(
			$_SESSION['dj'],
			$_POST['js_a'],
			'',
			$_POST['js_d'],
			$_POST['file_size'],
			$_POST['file'],
			0,
			$_POST['file_preview'],
			date('Y-m-d H:i:s'),
			$_POST['js_f'],
			$_POST['js_b'],
			$_POST['cover'],
			$_POST['js_c'],
			$_POST['js_e'],
			$_POST['file_hot'],
			$_POST['file_new']
		);

		if($action=='update'){
			if(!isset($_POST['id_file'])){ return false; }
			if($this->con->Update($productos_array,'archivos',$productos_data,'WHERE CodAudio='.$_POST['id_file'])){
				echo 'true';
			}else{
				echo 'false';
			}
		}else{
			if($this->con->Insert($productos_array,'archivos',$productos_data)){
				echo 'true';
			}else{
				echo 'false';
			}
		}

	}
}


?>