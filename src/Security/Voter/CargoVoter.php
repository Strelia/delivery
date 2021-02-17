<?php

namespace App\Security\Voter;

use App\Entity\Business;
use App\Entity\Cargo;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class CargoVoter extends Voter
{
    const EDIT = 'cargo-save';

    /**
     * @inheritDoc
     */
    protected function supports($attribute, $subject)
    {
        return in_array($attribute, [self::EDIT])
            && $subject instanceof Cargo;
    }

    /**
     * @inheritDoc
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface && !$user instanceof User || empty($user?->getCompany())) {
            return false;
        }

        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($user, $subject);
        }

        return false;
    }

    protected function canEdit(User $user, Cargo $cargo): bool
    {
        return $user->getCompany() === $cargo->getOwner();
    }
}
