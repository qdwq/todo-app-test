<?php

/*
 This work, including the code samples, is licensed under a Creative Commons BY-SA 3.0 license.
 */

namespace App\Service;

use App\Entity\Photos;
use App\Repository\PhotosRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class PhotosService.
 */
class PhotosService implements TaskServiceInterface
{
    public const PAGINATOR_ITEMS_PER_PAGE = 10;

    private PhotosRepository $photosRepository;

    private PaginatorInterface $paginator;

    private FileUploader $fileUploader;

    /**
     * PhotosController constructor.
     *
     * @param PhotosRepository   $photosRepository Photos repository
     * @param PaginatorInterface $paginator        paginator interface
     * @param FileUploader       $fileUploader     FileUploader
     */
    public function __construct(PhotosRepository $photosRepository, PaginatorInterface $paginator, FileUploader $fileUploader)
    {
        $this->photosRepository = $photosRepository;
        $this->paginator = $paginator;
        $this->fileUploader = $fileUploader;
    }

    /**
     * CreatePaginatedList.
     *
     * @param int $page Page
     *
     * @return PaginationInterface Pagination interface
     */
    public function createPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->photosRepository->queryAll(),
            $page,
            self::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * @param int $id id
     *
     * @return ?Photos
     */
    public function getOne(int $id): ?Photos
    {
        return $this->photosRepository->findOneById($id);
    }

    /**
     * Save.
     *
     * @param Photos            $photos Photos
     * @param UploadedFile|null $file   Uploaded file
     */
    public function save(Photos $photos, UploadedFile $file = null): void
    {
        if ($file) {
            $filename = $this->fileUploader->upload($file);
            $photos->setFilename($filename);
        }

        $photos->setUpdatedAt(new \DateTime());
        $this->photosRepository->save($photos);
    }

    /**
     * Delete.
     *
     * @param Photos $photos Photos
     */
    public function delete(Photos $photos): void
    {
        $this->photosRepository->delete($photos);
    }
}
