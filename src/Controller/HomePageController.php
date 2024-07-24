<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\FamilyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomePageController extends AbstractController
{
    public function __construct(
        private FamilyRepository $familyRepository
    )
    {
    }

    #[Route('/', name: 'app_home_page')]
    public function index(): Response
    {
        $user = $this->getUser();

        /** @var $user User */
        if (!($user instanceof User) || !$user->getFamily()) {
            return $this->render('home_page/index.html.twig', [
                'family_members' => null,
                'family_name' => null
            ]);
        }

        $family = $user->getFamily();
        $familyName = $family->getName();
        $familyMembers = $family->getUsers();

        return $this->render('home_page/index.html.twig', [
            'family_name' => $familyName,
            'family_members' => $familyMembers,
        ]);
    }
}
