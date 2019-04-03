<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Upload;

class UploadController extends Controller
{
    //
    public function image_upload(Request $request) {
    	$image = $request->file('photoURL');
    	$extension = $image->getClientOriginalExtension();
    	Storage::disk('public')->put($image->getFilename().'.'.$extension,  File::get($image));

    	$upload = new Upload();
    	$upload->icon_url = $image->getFilename().'.'.$extension;
    	$upload->mime = $image->getClientMimeType();
    	$upload->url = url('uploads/'.$upload->icon_url);
    	$upload->save();

    	return $upload;
    }
}
