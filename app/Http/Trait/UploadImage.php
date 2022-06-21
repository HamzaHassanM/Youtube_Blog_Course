<?php

namespace App\Http\Trait;

use \Illuminate\Support\Str;

trait UploadImage
{
    public function upload($file)
    {
        $filename = Str::uuid() . $file->getClientOriginalName();
        $file->move(public_path('images'), $filename);
        $path = 'images/' . $filename;
        return $path;
    }
}
