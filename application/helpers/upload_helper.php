<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('uploadImage'))
{
    function uploadImage($image_name)
    {
        $CI =& get_instance();
        $config['upload_path']   =   "uploads/";
        $config['allowed_types'] =   "gif|jpg|jpeg|png";
        $config['max_size']      =   "5000";
        $config['max_width']     =   "1907";
        $config['max_height']    =   "1280";
        $CI->load->library('upload',$config);
        if(!$CI->upload->do_upload($image_name))
        {
            echo $CI->upload->display_errors();
        }
        else
        {
            $finfo=$CI->upload->data();
            _createThumbnail($finfo['file_name']);
            $data['uploadInfo'] = $finfo;
            $data['thumbnail_name'] = $finfo['raw_name']. '_thumb' .$finfo['file_ext'];
            return $data;
        }
    }

}
if ( ! function_exists('_createThumbnail'))
{
    function _createThumbnail($filename)
    {
        $CI =& get_instance();
        $config['image_library']    = "gd2";
        $config['source_image']     = "uploads/" .$filename;
        $config['create_thumb']     = TRUE;
        $config['maintain_ratio']   = TRUE;
        $config['width'] = "80";
        $config['height'] = "80";
        $CI->load->library('image_lib',$config);
        if(!$CI->image_lib->resize())
        {
            echo $CI->image_lib->display_errors();
        }
    }
}
