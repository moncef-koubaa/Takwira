<?php

// src/Service/FileUploader.php
namespace App\Service;

use App\Entity\Image;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class ImageUploader
{
    public function __construct(
        private string $targetDirectory,
        private SluggerInterface $slugger,
        private EntityManagerInterface $entityManager
    ) {
    }

    public function upload(UploadedFile $file, $number): Image
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        try {
            $file->move($this->getTargetDirectory(), $fileName);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        $newImage = new Image();
        $newImage->setNumber($number);
        $newImage->setPath($fileName);

        $this->entityManager->persist($newImage);

        return $newImage;
    }

    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }
}