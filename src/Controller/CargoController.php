<?php

namespace App\Controller;

use App\Entity\Cargo;
use App\Form\CargoType;
use App\Repository\CargoRepository;
use App\Security\Voter\CargoVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cargo', name: 'cargo_')]
class CargoController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(Request $request, CargoRepository $cargoRepository): Response
    {
        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $cargoRepository->getPaginator($cargoRepository->getAllCargo($offset));
        return $this->render('cargo/index.html.twig', [
            'cargos' => $paginator,
            'previous' => $offset - CargoRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + CargoRepository::PAGINATOR_PER_PAGE),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $cargo = new Cargo();

        $form = $this->createForm(CargoType::class, $cargo);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $cargo->setOwner($this->getUser()->getCompany());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cargo);
            $entityManager->flush();

            return $this->redirectToRoute('cargo_search', ['id' => $this->getUser()->getCompany()->getId()]);
        }

        return $this->render('cargo/new.html.twig', [
            'cargo' => $cargo,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Cargo $cargo): Response
    {
        return $this->render('cargo/show.html.twig', [
            'cargo' => $cargo,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cargo $cargo): Response
    {
        $form = $this->createForm(CargoType::class, $cargo);
        $this->denyAccessUnlessGranted(CargoVoter::EDIT, $cargo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cargo_index');
        }

        return $this->render('cargo/edit.html.twig', [
            'cargo' => $cargo,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(Request $request, Cargo $cargo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cargo->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cargo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cargo_index');
    }
}
