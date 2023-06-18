<?php
/**
 * Comments repository.
 */

namespace App\Repository;

use App\Entity\Comments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class CategoryRepository.
 *
 * @method Comments|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comments|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comments[]    findAll()
 * @method Comments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentsRepository extends ServiceEntityRepository
{
    /**
     * Items per page.
     *
     * Use constants to define configuration options that rarely change instead
     * of specifying them in app/config/config.yml.
     * See https://symfony.com/doc/current/best_practices.html#configuration
     *
     * @constant int
     */
    public const PAGINATOR_ITEMS_PER_PAGE = 3;

    /**
     * CommentsRepository constructor.
     */
    /**
     * CommentsRepository constructor.
     *
     * @param ManagerRegistry $registry Registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comments::class);
    }

    /**
     * Save record.
     *
     * @param \App\Entity\Comments $comments Comments entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Comments $comments): void
    {
        $this->_em->persist($comments);
        $this->_em->flush();
    }

    /**
     * Delete record.
     *
     * @param \App\Entity\Comments $comments Comments entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Comments $comments): void
    {
        $this->_em->remove($comments);
        $this->_em->flush();
    }

    /**
     * Query all records.
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    public function queryAll(): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->orderBy('Comments.updatedAt', 'DESC');
    }

    /**
     * Query by photo id.
     *
     * @param int $photoId Photo id
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    public function queryByPhotoId(int $photoId): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->select('Comments')
            ->Where('Comments.photos = :photo_id')
            ->orderBy('Comments.updatedAt', ' DESC')
            ->setParameter('photo_id', $photoId);
    }

    /**
     * Get or create new query builder.
     *
     * @param \Doctrine\ORM\QueryBuilder|null $queryBuilder Query builder
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return $queryBuilder ?? $this->createQueryBuilder('Comments');
    }
}
