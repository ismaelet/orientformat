<?php

// Upload file
function upload_file($filePath, $src = false)
{

    $filePath = strpos($filePath, SERVER_ROOT) !== false || (defined('__PUBLIC_SERVER_ROOT__') && strpos($filePath, __PUBLIC_SERVER_ROOT__) !== false) ? $filePath : SERVER_ROOT.'/'.$filePath;

    if (! $src) {
        $src = $_FILES['file'];
    }

    $filePath = explode('/', $filePath);

    $file = array_pop($filePath);

    $directory = implode('/', $filePath);

    if (! file_exists($directory)) {
        mkdir($directory, 0777, true);
    }

    move_uploaded_file($src['tmp_name'], $directory.'/'.$file);
}

// Upload image
function upload_img($file_data)
{

    $error = false;

    $url = $file_data['url'];
    $size = $file_data['size'];
    $type = $file_data['type'] ?? 'img';
    $mode = $file_data['mode'] ?? 'min';
    $quality = $file_data['quality'] ?? 80;

    // get file data
    if (isset($file_data['key'])) {
        $img_name = $_FILES[$file_data['name'] ?? 'file']['name'][$file_data['key']];
        $img_temp = $_FILES[$file_data['name'] ?? 'file']['tmp_name'][$file_data['key']];
        $img_size = $_FILES[$file_data['name'] ?? 'file']['size'][$file_data['key']];
        $img_conf = $_FILES[$file_data['name'] ?? 'file']['error'][$file_data['key']];
    } else {
        $img_name = $_FILES[$file_data['name'] ?? 'file']['name'];
        $img_temp = $_FILES[$file_data['name'] ?? 'file']['tmp_name'];
        $img_size = $_FILES[$file_data['name'] ?? 'file']['size'];
        $img_conf = $_FILES[$file_data['name'] ?? 'file']['error'];
    }

    // generate file resolution and type string
    if ($type == 'img') {
        $conf_type = [IMAGETYPE_JPEG, IMAGETYPE_PNG];
    } elseif ($type == 'png') {
        $conf_type = [IMAGETYPE_PNG];
    } elseif ($type == 'jpg') {
        $conf_type = [IMAGETYPE_JPEG];
    }

    $img_type = exif_imagetype($img_temp);
    $img_res = getimagesize($img_temp);
    $src_w = $img_res[0] ?? 0;
    $src_h = $img_res[1] ?? 0;

    // check for errors
    if (! in_array($img_type, $conf_type)) {
        $error = 'file-type';
    } elseif ($img_conf || ! $src_w || ! $src_h) {
        $error = 'error';
    } else {

        $ratio = $src_w / $src_h;

        $x = $y = 0;

        if ($mode == 'min') {

            if ($ratio > 1) {
                $new_w = $size;
                $new_h = $size / $ratio;
            } else {
                $new_w = $size * $ratio;
                $new_h = $size;
            }
        } elseif ($mode == 'max') {

            if ($ratio > 1) {
                $new_w = $size * $ratio;
                $new_h = $size;
            } else {
                $new_w = $size;
                $new_h = $size / $ratio;
            }
        } elseif ($mode == 'crop') {

            [$new_w, $new_h] = $size;

            $new_ratio = $new_w / $new_h;

            if ($ratio > $new_ratio) {
                $src_w = $src_h * $new_ratio;
                $x = ($img_res[0] - $src_w) / 2;
            } else {
                $src_h = $src_w / $new_ratio;
                $y = ($img_res[1] - $src_h) / 2;
            }
        }

        $temp = imagecreatetruecolor($new_w, $new_h);

        $folder = substr($url, 0, strrpos($url, '/'));

        if (! file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        if ($type == 'png') {
            $orig = imagecreatefrompng($img_temp);
            imagealphablending($temp, false);
            imagesavealpha($temp, true);
            $trsp = imagecolorallocatealpha($temp, 255, 255, 255, 127);
            imagefilledrectangle($temp, 0, 0, $new_w, $new_h, $trsp);
            imagecopyresampled($temp, $orig, 0, 0, $x, $y, $new_w, $new_h, $src_w, $src_h);
            imagepng($temp, $url);
        } elseif ($type == 'jpg' || $type == 'img') {
            $orig = imagecreatefromstring(file_get_contents($img_temp));
            imagecopyresampled($temp, $orig, 0, 0, $x, $y, $new_w, $new_h, $src_w, $src_h);
            imagejpeg($temp, $url, $quality);
        }

        imagedestroy($orig);
        imagedestroy($temp);
    }

    return $error;
}
