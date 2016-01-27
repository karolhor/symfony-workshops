<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * Class OffensiveWordValidator
 */
class OffensiveWordValidator extends ConstraintValidator
{
    public static $offensiveWordsDictionary = ['duck', 'cat', 'dog'];
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof OffensiveWord) {
            throw new UnexpectedTypeException($constraint, OffensiveWord::class);
        }

        foreach (self::$offensiveWordsDictionary as $word) {
            if ($constraint->caseSensitive) {
                $hasOffensiveWord = strpos($value, $word) !== false;
            } else {
                $hasOffensiveWord = stripos($value, $word) !== false;
            }

            if($hasOffensiveWord) {
                $this->context
                    ->buildViolation($constraint->message)
                    ->setParameter('%word%', $word)
                    ->addViolation();

                return;
            }
        }
    }
}
