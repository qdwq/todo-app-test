<?php

/*
 This work, including the code samples, is licensed under a Creative Commons BY-SA 3.0 license.
 */

namespace App\Service;

use App\Entity\Photos;
use App\Repository\PhotosRepository;
use DateTime;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class PhotosService.
 */
class PhotosService
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
     */
    public function __construct(PhotosRepository $photosRepository, PaginatorInterface $paginator, FileUploader $fileUploader)
    {
        $this->photosRepository = $photosRepository;
        $this->paginator = $paginator;
        $this->fileUploader = $fileUploader;
    }

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
     */
    public function getOne(int $id): ?Photos
    {
        return $this->photosRepository->findOneById($id);
    }

    public function getOneWithComments(int $id): ?Photos
    {
        return $this->photosRepository->getOneWithComments($id);
    }

    public function save(Photos $photos, UploadedFile $file = null): void
    {
        if ($file) {
            $filename = $this->fileUploader->upload($file);
            $photos->setFilename($filename);
        }

        $photos->setUpdatedAt(new DateTime());
        $this->photosRepository->save($photos);
    }

    public function delete(Photos $photos): void
    {
        $this->photosRepository->delete($photos);
    }
}
