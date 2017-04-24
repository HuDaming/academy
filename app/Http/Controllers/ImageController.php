<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Intervention\Image\ImageManagerStatic as Image;
use File;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        $targetDir = self::getTargetDir($request->input('type'));
        $file = Input::file('file');

        $ext = $file->getClientOriginalExtension();
        $filename = $this->getFilename() . '.' . $ext;
        $img = Image::make($file);
        $img->save(public_path() . '/uploads/' . $targetDir . $filename);
        if ($img)
            return Config::get('admin.upload.host') . $targetDir . $filename;
        else
            return response('system error', 500);
    }

    /**
     * create filename
     *
     * @return string
     */
    protected function getFilename()
    {
        return date('His').strtolower(str_random());
    }

    /**
     * create target dir
     *
     * @param $type
     * @param bool $isExists
     * @return string
     */
    protected function getTargetDir($type, $isExists = true)
    {
        $subDir = $subDir1 = $subDir2 = '';
        if ($type == 'goods') {
            $subDir1 = date('Ym');
            $subDir2 = date('d');
            $subDir = $type . '/' .$subDir1 . '/' . $subDir2 . '/';
        }
        $isExists && self::checkDirExists($type, $subDir1, $subDir2);
        return $subDir;
    }

    /**
     * check type
     *
     * @param $type
     * @return string
     */
    protected function checkDirType($type)
    {
        return !in_array($type, ['goods']) ? 'temp' : $type;
    }

    /**
     * check Directory
     *
     * @param string $sub1
     * @param string $sub2
     * @return bool
     */
    protected function checkDirExists($type = '', $sub1 = '', $sub2 = '')
    {
        $type = self::checkDirType($type);

        $baseDir = public_path() . '/uploads/';

        $typeDir = $type ? ($baseDir . '/' . $type) : '';
        $subDir1 = $type && $sub1 !== '' ? ($typeDir . '/' . $sub1) : '';
        $subDir2 = $sub1 && $sub2 !== '' ? ($subDir1 . '/' . $sub2) : '';

        $res = $subDir2 ? File::exists($subDir2) : ($subDir1 ? File::exists($subDir1) : File::exists($typeDir));

        if (!$res) {
            $res = $typeDir && File::makeDirectory($typeDir);
            $res && $subDir1 && ($res = File::makeDirectory($subDir1));
            $res && $subDir1 && $subDir2 && ($res = File::makeDirectory($subDir2));
        }

        return $res;
    }
}
