<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\FamilyFormType;
use App\Repository\FamilyRepository;
use App\Repository\UserRepository;
use App\Service\FamilyService;
use App\Service\WishService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/family-wish-list')]
class FamilyWishListController extends AbstractController
{
    public function __construct(
       private WishService $wishService,
       private FamilyRepository $familyRepository,
        private FamilyService $familyService
    ) {
    }

    #[Route('/list/{familyId}', name: 'family_wish_list')]
    public function index(int $familyId): Response
    {
        $userId = $this->getUser()->getId();
        $wishes = $this->wishService->getWishesFromFamilyMembers($familyId, $userId);
        $familyMembers = $this->familyService->getOtherFamilyMembers($familyId, $userId);

        foreach ($familyMembers as $familyMember) {
            $wishes[] = $familyMember->getWishes();
        }
dd($wishes);
        return $this->render('family_wish_list/index.html.twig', [
            'wishes' => $wishes
        ]);
    }

    #[Route('/create', name: 'family_wish_list_create')]
    public function createFamily(Request $request): Response
    {
        $family = $this->familyRepository->create();

        $form = $this->createForm(FamilyFormType::class, $family);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $family = $form->getData();
            $family->addUser($this->getUser());

            $this->familyRepository->save($family, true);

            return $this->redirectToRoute('family_wish_list', [$family->getId()]);
        }

        return $this->render('family_wish_list/create.html.twig', [
            'form' => $form
        ]);
    }
}
