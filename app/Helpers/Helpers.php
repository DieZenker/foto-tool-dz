<?php

if (!function_exists('flash')) {
    function flash($text, $color='info', $icon=null) {
        \Illuminate\Support\Facades\Session::flash('flash', $text);
        \Illuminate\Support\Facades\Session::flash('flash-color', $color);
        if (!is_null($icon))
            \Illuminate\Support\Facades\Session::flash('flash-icon', $icon);
    }
}

if (!function_exists('fileLog')) {
    function fileLog($message, \App\Models\File $file, ?\App\Models\User $user=null) {
        try {
            if (is_null($user))
                $user = Auth::user();

            \App\Models\FileLog::create([
                'user_id' => $user->id,
                'file_id' => $file->id,
                'message' => $message
            ]);
        } catch (Exception $ex) {
            // Do nothing
        }

    }
}

function createThumbnail($source, $target, $width=500, $height=null)
{
    ini_set('memory_limit', '2G');
    try {
        $thumb = Image::make($source);
        $thumb->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $thumb->save($target);
    }catch (Exception $ex) {
        // Do nothing
    }
}
