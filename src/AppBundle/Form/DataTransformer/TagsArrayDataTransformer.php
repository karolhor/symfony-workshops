<?php

namespace AppBundle\Form\DataTransformer;

use AppBundle\Entity\Tag;
use AppBundle\Repository\TagsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * Class TagsArrayDataTransformer
 */
class TagsArrayDataTransformer implements DataTransformerInterface
{
    /** @var  TagsRepository */
    private $tagsRepository;

    /**
     * @param TagsRepository $tagsRepository
     */
    public function __construct(TagsRepository $tagsRepository)
    {
        $this->tagsRepository = $tagsRepository;
    }

    /**
     * Transforms array of Tags to a string: "tag1, tag2, tag3"
     *
     * @param Tag[] $tagsArray
     *
     * @return string
     */
    public function transform($tagsArray)
    {
        if ($tagsArray instanceof ArrayCollection) {
            $tagsArray = $tagsArray->toArray();
        }

        if (!is_array($tagsArray)) {
            return "";
        }

        $tagNames = implode(", ", $tagsArray);

        return $tagNames;
    }

    /**
     * Transforms a string ("tag1, tag2, tag3") to tags array
     *
     * @param string $tagsRawValue
     *
     * @return Tag[]
     */
    public function reverseTransform($tagsRawValue)
    {
        if (trim($tagsRawValue) == "") {
            return [];
        }

        $tagNamesArray = explode(",", $tagsRawValue);

        $tags = [];
        foreach ($tagNamesArray as $tagName) {
            $tags[] = trim($tagName);
        }

        $this->tagsRepository->batchInsert($tags);

        $values =  $this->tagsRepository
            ->findByMultipleValues($tags);

        return $values;
    }
}
