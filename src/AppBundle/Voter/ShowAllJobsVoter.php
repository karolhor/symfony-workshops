<?php

namespace AppBundle\Voter;

use AppBundle\Entity\Job;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ShowAllJobsVoter extends Voter
{
    const LAST_VIEW_TIME = 'last_view_time';

    /** @var  Session */
    private $session;

    /**
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }


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
        return $attribute == JobVoter::VIEW &&
            ($subject instanceof Job);
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
        $now = new \DateTime();
        if (!$this->session->has(self::LAST_VIEW_TIME)) {

            $this->session->set(self::LAST_VIEW_TIME,  $now->format('Y-m-d H:i:s'));
            $this->session->save();
        }

        $lastView = new \DateTimeImmutable($this->session->get(self::LAST_VIEW_TIME));

        $lastViewWith15seconds = $lastView->add(new \DateInterval('PT15S'));

        return $now < $lastViewWith15seconds;

    }
}
