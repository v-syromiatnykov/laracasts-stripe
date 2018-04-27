<?php

namespace App\Http\Controllers;

use App\Video;

class VideosController extends Controller
{
    public function show()
    {
        $video = new Video();

        return view('videos.show', compact('video'));
    }

}
