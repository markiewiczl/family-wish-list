<?php

namespace App\Service;

use App\Entity\User;

class WishService
{
    public function __construct(
        private FamilyService $familyService
    ) {
    }

    public function getWishesFromFamilyMembers(int $familyId, int $loggedInUserId): array
    {
        try {
            $familyMembers = $this->familyService->getOtherFamilyMembers($familyId, $loggedInUserId);

            $familyWishes = [[]];

            /** @var User $familyMember */
            foreach ($familyMembers as $familyMember) {
                $wishes = $familyMember->getWishes();
                $familyWishes[] = $familyMember->getId();
                $familyWishes[$familyMember->getId()][] = $wishes;
            }

            return $familyWishes;
        } catch (\Exception $e) {
            return [];
        }
    }
}