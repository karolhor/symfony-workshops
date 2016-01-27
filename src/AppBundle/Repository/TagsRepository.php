<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Tag;
use Doctrine\ORM\EntityRepository;

/**
 * Class TagsRepository
 */
class TagsRepository extends EntityRepository
{
    /**
     * @param string[] $values
     *
     * @return Tag[]
     */
    public function findByMultipleValues(array $values)
    {
        return $this->createQueryBuilder('t')
            ->select('t')
            ->where('t.value IN (:values)')
            ->setParameter('values', $values)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param string[] $tags
     */
    public function batchInsert(array $tags)
    {
        $conn = $this->_em->getConnection();

        $tagsPlaceholder = [];

        foreach ($tags as $tag) {
            $tagsPlaceholder[] = '(?)';
        }

        $sql = 'INSERT IGNORE INTO tags (value) VALUES '
            . implode(",", $tagsPlaceholder);

        $conn->executeQuery(
            $sql,
            $tags
        );
    }
}
