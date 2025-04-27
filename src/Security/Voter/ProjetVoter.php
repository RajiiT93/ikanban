<?php

namespace App\Security\Voter;

use App\Entity\Projet;
use App\Entity\Utilisateur;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ProjetVoter extends Voter
{
    public const EDIT = 'EDIT';

    protected function supports(string $attribute, $subject): bool
    {
        return $attribute === self::EDIT && $subject instanceof Projet;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof Utilisateur) {
            return false;
        }

        /** @var Projet $projet */
        $projet = $subject;

        // L'utilisateur peut éditer seulement son propre projet
        return $projet->getUtilisateur() === $user;
    }
}
