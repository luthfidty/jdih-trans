<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
defined('BASEPATH') or exit('No direct script access allowed');

/*
 * mapres uploader file helper
 */


if (!function_exists('imageresize')) {
    function imageresize($source_file,$max_width=475, $max_height=400)
    {

        $srcImg=$source_file['fullpath'];
        $dstImg=$source_file['filepath']."/thumbs/thumb_". $source_file['filename'];
        $imgsize = getimagesize($srcImg);
        $width = $imgsize[0];
        $height = $imgsize[1];
        $mime = $imgsize['mime'];
        if (!file_exists($source_file['filepath']."/thumbs/")) {
            mkdir($source_file['filepath']."/thumbs/", 0755, true);
        }

        switch ($mime) {
            case 'image/gif':
                $image_create = "imagecreatefromgif";
                $image = "imagegif";
                break;

            case 'image/png':
                $image_create = "imagecreatefrompng";
                $image = "imagepng";
                $quality = 9;
                break;

            case 'image/jpeg':
                $image_create = "imagecreatefromjpeg";
                $image = "imagejpeg";
                $quality = 85;
                break;

            default:
                return false;
                break;
        }

        $dst_img = imagecreatetruecolor($max_width, $max_height);
        $src_img = $image_create($srcImg);

        $width_new = $height * $max_width / $max_height;
        $height_new = $width * $max_height / $max_width;
        //if the new width is greater than the actual width of the image, then the height is too large and the rest cut off, or vice versa
        if ($width_new > $width) {
            //cut point by height
            $h_point = (($height - $height_new) / 2);
            //copy image
            imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
        } else {
            //cut point by width
            $w_point = (($width - $width_new) / 2);
            imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_width, $max_height, $width_new, $height);
        }

        $image($dst_img, $dstImg, $quality);

        if ($dst_img)
            imagedestroy($dst_img);
        if ($src_img)
            imagedestroy($src_img);
    }
    return;
}