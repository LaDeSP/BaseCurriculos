<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Upload; 

class UploadController extends Controller
{
    public function uploadSubmit(Request $request){
        
        if($request->hasFile('photo')) {
            $allowedfileExtension=['jpg', 'png'];
            $photo = $request->file('photo');

            foreach($photo as $pic){
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $check=in_array($extension, $allowedfileExtension);

                if($check){
                    
                }
            }
        }
    }
}
