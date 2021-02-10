<?php

namespace App\Security\Voter;

use App\Entity\Business;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class BusinessVoter extends Voter
{
    const EDIT = 'edit';
    protected function supports($attribute, $subject): bool
    {
        return in_array($attribute, [self::EDIT])
            && $subject instanceof Business;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface && !$user instanceof User) {
            return false;
        }

        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($subject, $user);
        }

        return false;
    }

    private function canEdit(Business $business, User $user)
    {
        return $business->getStaff()->contains($user);
    }
}
