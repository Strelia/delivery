<?php

namespace App\Security\Voter;

use App\Entity\CargoRequest;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class CargoRequestVoter extends Voter
{
    const EDIT = 'cargo-request-edit';
    const VIEW = 'cargo-request-view';
    const SET_EDITABLE = 'cargo-request-set-editable';

    protected function supports($attribute, $subject)
    {
        return in_array($attribute, [self::EDIT, self::VIEW])
            && $subject instanceof CargoRequest;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface && !$user instanceof User) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                return $this->edit($subject, $user);
            case self::VIEW:
                return $this->view($subject, $user);
            case self::SET_EDITABLE:
                return $this->setEditable($subject, $user);
        }
        return false;
    }

    private function edit(CargoRequest $cargoRequest, User $user)
    {
        return $cargoRequest->getIsEditable() && $cargoRequest->getExecutor() === $user->getCompany();
    }

    private function setEditable(CargoRequest $cargoRequest, User $user)
    {
        return $cargoRequest->getCargo()->getOwner() === $user->getCompany();
    }

    private function view(CargoRequest $cargoRequest, User $user)
    {
        return !$cargoRequest->getCargo()->getIsHiddenUserRequest() ||
            $cargoRequest->getExecutor() === $user->getCompany()
            || $cargoRequest->getCargo()->getOwner() === $user->getCompany();
    }
}
