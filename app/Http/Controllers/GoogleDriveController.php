<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GoogleDriveController extends Controller
{
    // Upload video to Google Drive
    public function uploadVideo(Request $request)
    {

        $file = $request->file('video');
        $filePath = $file->getClientOriginalName();
        $uploadedFile = Storage::disk('google')->put($filePath, file_get_contents($file));
        $fileId = collect(Storage::disk('google')->listContents('/', false))
            ->where('name', $filePath)
            ->first()['path'];

        $publicUrl = "https://drive.google.com/uc?id={$fileId}&export=view";

        return response()->json(['message' => 'Video uploaded successfully!', 'url' => $publicUrl]);
    }

    // Display the video
    public function playVideo($id)
    {
        $url = "https://drive.google.com/uc?id={$id}&export=download";

        return view('play', compact('url'));
    }
}
