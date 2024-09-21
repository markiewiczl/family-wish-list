<?php

namespace App\Controller;

use App\Form\FamilyFormType;
use App\Repository\FamilyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/family', name: 'family_')]
class FamilyController extends AbstractController
{
    public function __construct(
        private readonly FamilyRepository $familyRepository
    )
    {
    }

    #[Route('/settings/{familyId}', name: 'settings')]
    public function index(int $familyId): Response
    {
        $family = $this->familyRepository->find($familyId);

        return $this->render('family/index.html.twig', [
            'family_name' => $family->getName(),
        ]);
    }
    #[Route('/create', name: 'create')]
    public function createFamily(Request $request): Response
    {
        $family = $this->familyRepository->create();

        $form = $this->createForm(FamilyFormType::class, $family);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $family = $form->getData();

            $this->familyRepository->save($family, true);

            return $this->redirectToRoute('family_settings', ['familyId' => $family->getId()]);
        }

        return $this->render('family/create.html.twig', [
            'form' => $form,
        ]);
    }
}
