<?php

namespace App\Controller;

use App\Entity\CargoRequest;
use App\Form\CargoRequestType;
use App\Repository\CargoRequestRepository;
use App\Security\Voter\CargoRequestVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cargo/request', name: 'cargo_request_')]
class CargoRequestController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(CargoRequestRepository $cargoRequestRepository): Response
    {
        $this->getUser();
        return $this->render('cargo_request/index.html.twig', [
            'cargo_requests' => $cargoRequestRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(CargoRequest $cargoRequest): Response
    {
        $this->denyAccessUnlessGranted(CargoRequestVoter::VIEW, $cargoRequest);
        return $this->render('cargo_request/show.html.twig', [
            'cargo_request' => $cargoRequest,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CargoRequest $cargoRequest): Response
    {
        $this->denyAccessUnlessGranted(CargoRequestVoter::EDIT, $cargoRequest);
        $form = $this->createForm(CargoRequestType::class, $cargoRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cargo_show', ['id:' => $cargoRequest->getCargo()->getId()]);
        }

        return $this->render('cargo_request/edit.html.twig', [
            'cargo_request' => $cargoRequest,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(Request $request, CargoRequest $CargoRequest): Response
    {
        if ($this->isCsrfTokenValid('delete'.$CargoRequest->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($CargoRequest);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cargo_request_index');
    }

    #[Route('/{id}', name: 'change_status', methods: ['POST'])]
    public function changeStatus(Request $request, CargoRequest $cargoRequest): Response
    {
        if ($this->isCsrfTokenValid('cargo_request'.$cargoRequest->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $cargoRequest->setStatus($request->request->get('status'));
            $entityManager->persist($cargoRequest);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cargo_show', ['id' => $cargoRequest->getCargo()->getId()]);
    }
}
