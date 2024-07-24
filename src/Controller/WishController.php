<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Wish;
use App\Form\ProductFormType;
use App\Form\WishFormType;
use App\Repository\ProductRepository;
use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/wish')]

class WishController extends AbstractController
{
    public function __construct(
        private WishRepository $wishRepository,
        private ProductRepository $productRepository
    )
    {
    }

    #[Route('/create', name: 'create_wish')]

    public function index(Request $request): Response
    {
        $product = $this->productRepository->create();

        $form = $this->createForm(ProductFormType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Product $product */
            $product = $form->getData();

            $wish = $this->wishRepository->create();
            $wish->setOwner($this->getUser());
            $wish->setProduct($product);

            $this->wishRepository->save($wish, true);

            $product->setWish($wish);

            $this->productRepository->save($product, true);

            return $this->redirectToRoute('family_wish_list', ['familyId' => 1]);
        }
        return $this->render('wish/index.html.twig', [
            'form' => $form
        ]);
    }
}
