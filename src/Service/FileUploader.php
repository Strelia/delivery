<?php


namespace App\Service;


use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private string $targetDirectory;

    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function upload($prefix, UploadedFile $file, ?string $oldFile = null)
    {
//        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
//        $safeFilename = $originalFilename;
//        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
        if (!$file) {
            return null;
        }

        $fullPath = $this->getTargetDirectory() . $prefix . DIRECTORY_SEPARATOR;

        do {
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $dir = str_split($fileName, 4);
            array_pop($dir);
            $dir = implode(DIRECTORY_SEPARATOR, $dir);
            mkdir($fullPath . $dir, 0777, true);
        } while (file_exists($fullPath . $dir . DIRECTORY_SEPARATOR. $fileName));
        $file->move($fullPath . $dir, $fileName);

        return $prefix . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . $fileName;
    }

    protected function getTargetDirectory(): string
    {
        return $this->targetDirectory . DIRECTORY_SEPARATOR;
    }

    public function deleteFile($filePath): bool
    {
        if (
            $filePath &&
            file_exists($this->getTargetDirectory() . $filePath) &&
            is_file($this->getTargetDirectory() . $filePath)
        ) {
            return @unlink($filePath);
        }
        return false;
    }
}