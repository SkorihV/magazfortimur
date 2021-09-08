<?php

namespace App\FS;

class FS
{
   public function delDir($dir) {
        $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? $this->delDir("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }

    public function scanDir(string $dirname) {
        $list = scandir($dirname);

        $list = array_filter($list, function ($item){
            return !in_array($item, ['.', '..']);
        });

        $filenames = [];
        foreach ($list as $fileItem) {
            $filePath = $dirname . '/' . $fileItem;

            if (!is_dir($filePath)) {
                $filenames[] = $filePath;
            } else {
                $filenames = array_merge($filenames, $this->scanDir($filePath));
            }
        }

        return $filenames;
    }

}