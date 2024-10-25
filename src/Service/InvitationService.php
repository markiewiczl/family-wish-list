<?php

namespace App\Service;

use App\Entity\FamilyInterface;
use App\Entity\InvitationInterface;
use App\Repository\InvitationRepository;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface; // Use the interface

class InvitationService
{
    public function __construct(
        private readonly InvitationRepository $invitationRepository,
        private readonly TokenGeneratorInterface $tokenGenerator // Use TokenGeneratorInterface
    ) {
    }

    public function createInvitationLinkForFamily(FamilyInterface $family): InvitationInterface
    {
        $invitation = $this->invitationRepository->create();

        $token = $this->tokenGenerator->generateToken(); // Generate the token

        $invitation->setFamily($family);
        $invitation->setToken($token);

        $this->invitationRepository->save($invitation, true);

        return $invitation;
    }

    public function getTokenFromInvitation(InvitationInterface $invitation): string
    {
        return $invitation->getToken();
    }
}
