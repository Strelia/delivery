<?php

namespace App\Controller;

use App\Entity\Business;
use App\Form\BusinessType;
use App\Repository\BusinessRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/business', name: 'business_')]
class BusinessController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(Request $request, BusinessRepository $businessRepository): Response
    {
        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $businessRepository->getPaginator($offset);
        return $this->render('business/index.html.twig', [
            'businesses' => $paginator,
            'previous' => $offset - BusinessRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + BusinessRepository::PAGINATOR_PER_PAGE),
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Business $business): Response
    {
        return $this->render('business/show.html.twig', [
            'business' => $business,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Business $business, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(BusinessType::class, $business);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form['logo']->getData()) {
                $fileUploader->deleteFile($business->getLogo());
                $business->setLogo($fileUploader->upload('images', $form['logo']?->getData()));
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('business_index');
        }

        return $this->render('business/edit.html.twig', [
            'business' => $business,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(Request $request, Business $business): Response
    {
        if ($this->isCsrfTokenValid('delete'.$business->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $business->setStatus(Business::STATUS_REMOVED);
            $entityManager->persist($business);
            $entityManager->flush();
        }

        return $this->redirectToRoute('business_index');
    }
}
