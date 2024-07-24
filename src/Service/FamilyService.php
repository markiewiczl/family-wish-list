<?php

namespace App\Service;

use App\Repository\FamilyRepository;
use Exception;

class FamilyService
{
    /**
     * @param FamilyRepository $familyRepository
     */
    public function __construct(
        private FamilyRepository $familyRepository
    ) {
    }

    /**
     * @param int $familyId
     * @param int $loggedInUserId
     * @return array
     * @throws Exception
     */
    public function getOtherFamilyMembers(int $familyId, int $loggedInUserId): array
    {
        $family = $this->familyRepository->find($familyId);

        if (!$family) {
            throw new Exception('Nie znaleziono rodziny');
        }

        return array_filter($family->getUsers()->toArray(), fn($user) => $user->getId() !== $loggedInUserId);
    }
}