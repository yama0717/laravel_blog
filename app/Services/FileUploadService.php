<?php
 
namespace App\Services;
 
class FileUploadService {
 
    public function saveImage($image){
        $path = '';
        if ( isset($image) === true ){
            $path = $image->store('items', 'public');
        }
        return $path;
    }
    
    public function saveUserImage($image){
        $path = '';
        if (isset($image) === true){
            $path = $image->store('user_photos', 'public');
        }
        return $path;
    }
}