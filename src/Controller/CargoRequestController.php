<?php

namespace App\Controller;

use App\Entity\Cargo;
use App\Entity\CargoRequest;
use App\Form\CargoRequestType;
use App\Repository\CargoRequestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('', name: 'request_cargo_')]
class CargoRequestController extends AbstractController
{
    #[Route('/cargo/request', name: 'index', methods: ['GET'])]
    public function index(CargoRequestRepository $CargoRequestRepository): Response
    {
        $this->getUser();
        return $this->render('request_cargo/index.html.twig', [
            'request_cargos' => $CargoRequestRepository->findAll(),
        ]);
    }

    #[Route('/cargo/{id}/request/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, Cargo $cargo): Response
    {
        $CargoRequest = new CargoRequest();
        $CargoRequest->setPrice($cargo->getPrice());
        $CargoRequest->setWeight($cargo->getWeight());
        $CargoRequest->setVolume($cargo->getVolume());
        $form = $this->createForm(CargoRequestType::class, $CargoRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $CargoRequest->setExecutor($this->getUser()->getCompany());
            $CargoRequest->setCargo($cargo);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($CargoRequest);
            $entityManager->flush();

            return $this->redirectToRoute('cargo_show', ['id:' => $cargo->getId()]);
        }

        return $this->render('request_cargo/new.html.twig', [
            'request_cargo' => $CargoRequest,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/cargo/request/{id}', name: 'show', methods: ['GET'])]
    public function show(CargoRequest $CargoRequest): Response
    {
        return $this->render('request_cargo/show.html.twig', [
            'request_cargo' => $CargoRequest,
        ]);
    }

    #[Route('/cargo/request/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CargoRequest $CargoRequest): Response
    {
        $form = $this->createForm(CargoRequestType::class, $CargoRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cargo_show', ['id:' => $CargoRequest->getCargo()->getId()]);
        }

        return $this->render('request_cargo/edit.html.twig', [
            'request_cargo' => $CargoRequest,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/cargo/request/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(Request $request, CargoRequest $CargoRequest): Response
    {
        if ($this->isCsrfTokenValid('delete'.$CargoRequest->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($CargoRequest);
            $entityManager->flush();
        }

        return $this->redirectToRoute('request_cargo_index');
    }
}
