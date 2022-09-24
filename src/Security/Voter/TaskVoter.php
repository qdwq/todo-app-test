<?php

namespace App\Security\Voter;

use App\Entity\Comments;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class TaskVoter.
 */
class TaskVoter extends Voter
{
    public const CREATE = 'create';
    public const EDIT = 'edit';
    public const VIEW = 'view';
    public const DELETE = 'delete';

    /**
     * construct method.
     *
     * @param Security $security
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * support function.
     *
     * @param $attribute
     * @param $subject
     *
     * @return bool
     */
    protected function supports($attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::VIEW, self::DELETE, self::CREATE]);
//            && $subject instanceof \App\Entity\Comments;
    }

    /**
     * voteOnAttribute.
     *
     * @param $attribute
     * @param $subject
     * @param TokenInterface $token
     *
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        if (in_array('ROLE_ADMIN', $user->getRoles()) || ((self::CREATE == $attribute) && ($subject instanceof Comments))
        ) {
            return true;
        }

        return false;
    }
}
