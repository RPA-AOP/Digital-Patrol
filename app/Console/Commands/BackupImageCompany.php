<?php

namespace App\Console\Commands;

use App\Models\ReportAccident;
use App\Models\ReportAccidentAttachment;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use SplFileInfo;

class BackupImageCompany extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:image {id_company : id company}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup Image Company';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $idCompany = $this->argument('id_company');

        $timestamp = Carbon::now()->timestamp;

//        $files = ReportPatrolFiles::whereIdCompany($idCompany)->get();
//        if ($files->count() > 0) {
//            $tempFolder = "temp/$idCompany/";
//            Storage::makeDirectory($tempFolder);
//            foreach ($files as $file) {
////            $filePath = dirname($file->path);
////            if (!File::isDirectory(Storage::path($filePath))) {
////                Storage::makeDirectory($filePath);
////            }
//                File::copyDirectory($file->path, $tempFolder.$file->path);
//                File::copy($file->path, $tempFolder.$file->path);
//            }
//            $filePath = Storage::path("$tempFolder/image-$idCompany-$timestamp.zip");
//
//            if (Storage::disk('local')->exists($filePath)) {
//                Storage::delete($filePath);
//            }
//            $zip = new \ZipArchive();
//            if ($zip->open($filePath, \ZipArchive::CREATE) !== true) {
//                Log::debug('Cannot open '.$filePath);
//                return false;
//            }
////            dd(Storage::path($tempFolder));
//            self::addContent($zip, Storage::path($tempFolder."report"));
//            return $zip->close();
//        }

        $accidentReport = ReportAccident::whereIdCompany($idCompany);
        $filesAccident = ReportAccidentAttachment::joinSub($accidentReport, 'report', 'report.report_accident_id',
            'report_accident_attachmet.report_accident_id')
            ->get();


        foreach ($filesAccident as $fileAccident) {

        }

        return print "Files not found";

    }

    private static function addContent(\ZipArchive $zip, string $path): void
    {
        ini_set('max_execution_time', 1200); //300 seconds = 5 minutes
        ini_set('memory_limit', '512M'); //300 seconds = 5 minutes

        /** @var SplFileInfo[] $files */
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(
                $path,
                \FilesystemIterator::FOLLOW_SYMLINKS
            ),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        while ($iterator->valid()) {
            if (!$iterator->isDot()) {
                $filePath = $iterator->getPathName();
                $relativePath = substr($filePath, strlen($path) + 1);

                if (!$iterator->isDir()) {
                    $zip->addFile($filePath, $relativePath);
                } else {
                    if ($relativePath) {
                        $zip->addEmptyDir($relativePath);
                    }
                }
            }
            $iterator->next();
        }
    }

}
