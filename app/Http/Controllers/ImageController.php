<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\images;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{


  public function storeimage(Request $request)
{
    $request->validate([
        'image' => 'required|image|max:10240', 
    ]);

    $folderName = 'eco/' . date('Y/m/d');
    $uploadedPath = Storage::disk('cloudinary')->put($folderName, $request->file('image'));

    $cloudinaryUrl = Storage::disk('cloudinary')->url($uploadedPath);

    $image = Images::create([
        'image' => $cloudinaryUrl, 
    ]);

    return response()->json([
        'message' => 'Image uploaded successfully!',
        'url' => $cloudinaryUrl,
    ]);
}



}