<?php

namespace App\Controller;

use App\Entity\FamilyInterface;
use App\Entity\User;
use App\Form\FamilyFormType;
use App\Repository\FamilyRepository;
use App\Repository\InvitationRepository;
use App\Service\InvitationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/family', name: 'family_')]
class FamilyController extends AbstractController
{
    public function __construct(
        private readonly FamilyRepository $familyRepository,
        private readonly InvitationRepository $invitationRepository,
        private readonly InvitationService $invitationService,
    )
    {
    }

    #[Route('/settings/{familyId}', name: 'settings')]
    public function index(int $familyId): Response
    {
        $family = $this->familyRepository->find($familyId);

        if (!$family->getInvitation()) {
            $invitation = $this->invitationService->createInvitationLinkForFamily($family);
        } else {
            $invitation = $family->getInvitation();
        }
        /** @var User $user */
        $user = $this->getUser();
        dd($user->getFamily());

        $token = $this->invitationService->getTokenFromInvitation($invitation);

        return $this->render('family/index.html.twig', [
            'family_name' => $family->getName(),
            'token' => $token
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

    #[Route('/invitation/{token}', name: 'add_user_with_invitation')]
    public function addUserToFamilyWithInvitation(string $token)
    {
        $user = $this->getUser();

        $invitation = $this->invitationRepository->findOneBy(['token' => $token]);

        /** @var FamilyInterface $family */
        $family = $invitation->getFamily();

        $family->addUser($user);

        $this->familyRepository->save($family, true);

        return $this->redirectToRoute('family_settings', ['familyId' => $family->getId()]);
    }
}
