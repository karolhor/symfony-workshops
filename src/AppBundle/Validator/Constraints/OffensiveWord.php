<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class OffensiveWord
 *
 * @Annotation
 */
class OffensiveWord extends Constraint
{
    public $message = "You cannot use offensive word: '%word%'";

    /** @var bool */
    public $caseSensitive;

    public function getRequiredOptions()
    {
        return ['caseSensitive'];
    }
}
