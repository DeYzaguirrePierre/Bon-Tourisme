<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Entity\Lieu;
use App\Form\AvisType;
use App\Repository\LieuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LieuController extends AbstractController
{
    private LieuRepository $lieuRepository;

    public function __construct(LieuRepository $lieuRepository)
    {
        $this->lieuRepository = $lieuRepository;
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'lieux_culturels' => $this->lieuRepository->findByType('Culturel'),
            'lieux_naturels' => $this->lieuRepository->findByType('Naturel'),
            'lieux_vip' => $this->lieuRepository->findByType('VIP'),
        ]);
    }

    #[Route('/lieux/{type}', name: 'lieu_list')]
    public function listByType(string $type): Response
    {
        $typesMapping = [
            'culturels' => 'Culturel',
            'naturels' => 'Naturel',
            'vip' => 'VIP',
        ];

        $typeLabel = $typesMapping[strtolower($type)] ?? null;

        if (!$typeLabel) {
            throw $this->createNotFoundException('Type de lieu non valide.');
        }

        return $this->render('lieu/list.html.twig', [
            'type' => ucfirst($type),
            'lieux' => $this->lieuRepository->findByType($typeLabel),
        ]);
    }

    #[Route('/lieu/{id}', name: 'lieu_detail')]
    public function detail(
        Lieu $lieu,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $user = $this->getUser();
        $form = null;

        if ($user) {
            $avis = new Avis();
            $form = $this->createForm(AvisType::class, $avis);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $avis->setLieu($lieu);
                $avis->setUser($user);
                $avis->setDateCreation(new \DateTime());

                $entityManager->persist($avis);
                $entityManager->flush();

                $this->addFlash('success', 'Votre avis a été ajouté avec succès !');
                return $this->redirectToRoute('lieu_detail', ['id' => $lieu->getId()]);
            }
        }

        return $this->render('lieu/detail.html.twig', [
            'lieu' => $lieu,
            'form' => $form ? $form->createView() : null,
            'avis' => $lieu->getAvis(),
        ]);
    }
}
