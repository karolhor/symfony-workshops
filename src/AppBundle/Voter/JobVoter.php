<?php

namespace AppBundle\Voter;

use AppBundle\Entity\Job;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Class JobVoter
 */
class JobVoter extends Voter
{
    const VIEW = 'view';
    const EDIT = 'edit';

    /**
     * Determines if the attribute and subject are supported by this voter.
     *
     * @param string $attribute An attribute
     * @param mixed $subject The subject to secure, e.g. an object the user wants to access or any other PHP type
     *
     * @return bool True if the attribute and subject are supported, false otherwise
     */
    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [self::VIEW, self::EDIT])) {
            return false;
        }

        if (!$subject instanceof Job) {
            return false;
        }

        return true;
    }

    /**
     * Perform a single access check operation on a given attribute, subject and token.
     *
     * @param string $attribute
     * @param mixed $subject
     * @param TokenInterface $token
     *
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        /** @var Job $job */
        $job = $subject;

        switch($attribute) {
            case self::EDIT:
                return $this->canEdit($job, $user);
            case self::VIEW:
                return $this->canView($job, $user);
        }

        return false;
    }

    /**
     * @param Job $job
     * @param User $user
     *
     * @return bool
     */
    private function canEdit(Job $job, User $user)
    {
        return $job->isAuthor($user);
    }

    /**
     * @param Job $job
     * @param User $user
     *
     * @return bool
     */
    private function canView(Job $job, User $user)
    {
        return $this->canEdit($job, $user) ||
            $job->isPublished();
    }
}
