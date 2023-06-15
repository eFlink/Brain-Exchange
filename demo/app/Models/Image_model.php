<?php

namespace App\Models;

use CodeIgniter\Model;
use Imagick;
use ImagickPixel;

class Image_model extends Model 
{
    protected $allowedFields = ['filename', 'path'];

    function rotate($path, $filename)
    {
        $imagick = new \Imagick($path.$filename);
        $imagick->rotateImage(new \ImagickPixel(), 180);
        $imagick->writeImage($path.$filename);
        $imagick->clear();
        $imagick->destroy();
    }
}