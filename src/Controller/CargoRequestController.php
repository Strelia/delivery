<?php

namespace App\Controller;

use App\Entity\CargoRequest;
use App\Form\CargoRequestType;
use App\Repository\CargoRequestRepository;
use App\Security\Voter\CargoRequestVoter;
use App\Workflow\CargoRequestTransitions;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Workflow\Registry;
use Symfony\Component\Workflow\Workflow;

#[Route('/cargo/request', name: 'cargo_request_')]
class CargoRequestController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(CargoRequestRepository $cargoRequestRepository): Response
    {
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

    #[Route('/{id}/status', name: 'change_status', methods: ['GET'])]
    public function changeStatus(Request $request, Registry $workflows): Response
    {
        $cargoRequest = new CargoRequest();
        $cargoRequest->setStatus(CargoRequestTransitions::STATUS_APPROVED);

        $workflow = $workflows->get($cargoRequest);
        $workflow->getEnabledTransitions($cargoRequest);
//        dump($trs);

        $ff = $workflow->can($cargoRequest, 'test');
        echo $ff;
        exit();
//        dd($workflow->getEnabledTransitions($cargoRequest));
//        try {
////            $workflow->can($cargoRequest, 'execution_confirmed');
////            $test = $workflow->apply($cargoRequest, 'approved');
//        } catch (LogicException $exception) {
//            dd($exception->getMessage());
////            $this->addFlash('error', $exception->getMessage());
//        }
//
//        dd('fff');

//        if ($this->isCsrfTokenValid('cargo_request'.$cargoRequest->getId(), $request->request->get('_token'))) {
//            $entityManager = $this->getDoctrine()->getManager();
//            $cargoRequest->setStatus($request->request->get('status'));
//            $entityManager->persist($cargoRequest);
//            $entityManager->flush();
//        }

//        return $this->redirectToRoute('cargo_show', ['id' => $cargoRequest->getCargo()->getId()]);
    }
}
