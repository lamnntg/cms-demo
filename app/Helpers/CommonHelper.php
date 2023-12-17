<?php

use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

/**
 * upload image func
 *
 * @return string
 */
function uploadImage($dataImage, $path, $dataSave)
{
    // Lưu ảnh
    $filename = Str::uuid(time()) . '-' . trim($dataImage->getClientOriginalName(), ' ');
    $uploadPath = public_path($path);

    //Kiểm tra xem thư mục đã tồn tại chưa, nếu không thì tạo mới
    if (!File::exists($uploadPath)) {
        File::makeDirectory($uploadPath, 0777, true, true);
    }

    if (move_uploaded_file($dataImage, $uploadPath . '/' . $filename)) {
        $dataSave['images'][] = $path . '/' . $filename;
        return  $dataSave;
    } else {
        return [Response::HTTP_INTERNAL_SERVER_ERROR, ['message' => 'Upload file local fail!']];
    }
}

/**
 * delete image func
 *
 * @return string
 */
function deleteImageLocalStorage($image)
{
    if (!empty($image)) {
        Storage::delete($image);
        File::delete(public_path($image));
    }
}


