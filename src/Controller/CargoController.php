<?php

namespace App\Controller;

use App\Entity\Cargo;
use App\Entity\CargoRequest;
use App\Form\CargoRequestType;
use App\Form\CargoType;
use App\Repository\CargoRepository;
use App\Repository\CargoRequestRepository;
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
        $paginator = $cargoRepository->getPaginator($cargoRepository->getAllCargo($offset, [Cargo::STATUS_CLOSE]));
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

            // TODO: lost route
            return $this->redirectToRoute('cargo_search', ['id' => $this->getUser()->getCompany()->getId()]);
        }

        return $this->render('cargo/new.html.twig', [
            'cargo' => $cargo,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/request/new', name: 'request_new', methods: ['GET', 'POST'])]
    public function newRequest(Request $request, Cargo $cargo): Response
    {
        $cargoRequest = new CargoRequest();
        $cargoRequest->setPrice($cargo->getPrice());
        $cargoRequest->setWeight($cargo->getWeight());
        $cargoRequest->setVolume($cargo->getVolume());
        $form = $this->createForm(CargoRequestType::class, $cargoRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cargoRequest->setExecutor($this->getUser()->getCompany());
            $cargoRequest->setCargo($cargo);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cargoRequest);
            $entityManager->flush();

            return $this->redirectToRoute('cargo_show', ['id' => $cargo->getId()]);
        }

        return $this->render('cargo_request/new.html.twig', [
            'cargo_request' => $cargoRequest,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Cargo $cargo, CargoRequestRepository $cargoRequestRepository): Response
    {
        return $this->render('cargo/show.html.twig', [
            'cargo' => $cargo,
            'my_request' => $cargoRequestRepository->getOneByBussiness($this->getUser()?->getCompany())
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

    #[Route('/{id}', name: 'change_status', methods: ['POST'])]
    public function changeStatus(Request $request, Cargo $cargo): Response
    {
        if ($this->isCsrfTokenValid('change_status'.$cargo->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            if ($cargo->getStatus() === Cargo::STATUS_OPEN) {
                $cargo->setStatus(Cargo::STATUS_CLOSE);
            } elseif ($cargo->getStatus() === Cargo::STATUS_CLOSE) {
                $cargo->setStatus(Cargo::STATUS_OPEN);
            }
            $entityManager->persist($cargo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cargo_show', ['id' => $cargo->getId()]);
    }
}
