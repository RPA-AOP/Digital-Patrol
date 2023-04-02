<?php

namespace App\Helpers;

use App\Models\fileUpload;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UploadFile
{

  public static function uploadMultiple($files): ?string
  {
    if ($files) {
      foreach ($files as $file) {
        return self::upload($file);
      }
    }
    return null;
  }

  public static function uploadSingle($file, $path = null): ?string
  {
      if ($file) {
          return self::upload($file, $path);
      }
      return null;
  }

  /**
   * @param $file
   * @return string|void
   */
    public static function upload($file, $path = null)
    {
        $datePath = Carbon::now()->format('Y/m/d');
        $extention = $file->getClientOriginalExtension();
        $oriname = $file->getClientOriginalName();
        if ($path)
            $datePath = $path . "/" . $datePath;
        $pathFile = $datePath . "/" . $oriname;
        if (!File::isDirectory(Storage::path($datePath))) {
            Storage::makeDirectory($datePath);
        }
        $uploaded = Storage::disk('local')->put(
            $pathFile, file_get_contents($file)
        );
        if ($uploaded) {
            return $pathFile;
        }
  }
}

