<?php

namespace AppBundle\Form\DataTransformer;

use AppBundle\Entity\Tag;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * Class TagsArrayDataTransformer
 */
class TagsArrayDataTransformer implements DataTransformerInterface
{

    /**
     * Transforms array of Tags to a string: "tag1, tag2, tag3"
     *
     * @param Tag[] $tagsArray
     *
     * @return string
     */
    public function transform($tagsArray)
    {
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
        $tagNamesArray = explode(",", $tagsRawValue);

        $tags = [];
        foreach ($tagNamesArray as $tagName) {
            $tag = new Tag();
            $tag->setValue(trim($tagName));

            $tags[] = $tag;
        }

        return $tags;
    }
}
