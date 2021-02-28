<?php

namespace App\Controller;

use App\Entity\Cargo;
use App\Entity\RequestCargo;
use App\Form\RequestCargoType;
use App\Repository\RequestCargoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('', name: 'request_cargo_')]
class RequestCargoController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(RequestCargoRepository $requestCargoRepository): Response
    {
        $this->getUser();
        return $this->render('request_cargo/index.html.twig', [
            'request_cargos' => $requestCargoRepository->findAll(),
        ]);
    }

    #[Route('/cargo/{id}/request/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, Cargo $cargo): Response
    {
        $requestCargo = new RequestCargo();
        $requestCargo->setPrice($cargo->getPrice());
        $requestCargo->setWeight($cargo->getWeight());
        $requestCargo->setVolume($cargo->getVolume());
        $form = $this->createForm(RequestCargoType::class, $requestCargo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $requestCargo->setExecutor($this->getUser()->getCompany());
            $requestCargo->setCargo($cargo);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($requestCargo);
            $entityManager->flush();

            return $this->redirectToRoute('cargo_show', ['id:' => $cargo->getId()]);
        }

        return $this->render('request_cargo/new.html.twig', [
            'request_cargo' => $requestCargo,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(RequestCargo $requestCargo): Response
    {
        return $this->render('request_cargo/show.html.twig', [
            'request_cargo' => $requestCargo,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RequestCargo $requestCargo): Response
    {
        $form = $this->createForm(RequestCargoType::class, $requestCargo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cargo_show', ['id:' => $requestCargo->getCargo()->getId()]);
        }

        return $this->render('request_cargo/edit.html.twig', [
            'request_cargo' => $requestCargo,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(Request $request, RequestCargo $requestCargo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$requestCargo->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($requestCargo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('request_cargo_index');
    }
}
