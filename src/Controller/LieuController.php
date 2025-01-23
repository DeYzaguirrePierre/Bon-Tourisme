<?php

namespace App\Controller;

use App\Repository\LieuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LieuController extends AbstractController
{
    private $lieuRepository;

    public function __construct(LieuRepository $lieuRepository)
    {
        $this->lieuRepository = $lieuRepository;
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $lieux_culturels = $this->lieuRepository->findByType('Culturel');
        $lieux_naturels = $this->lieuRepository->findByType('Naturel');
        $lieux_vip = $this->lieuRepository->findByType('VIP');

        return $this->render('home/index.html.twig', [
            'lieux_culturels' => $lieux_culturels,
            'lieux_naturels' => $lieux_naturels,
            'lieux_vip' => $lieux_vip,
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

        $lieux = $this->lieuRepository->findByType($typeLabel);

        if (empty($lieux)) {
            $this->addFlash('warning', "Aucun lieu $typeLabel trouvé.");
        }

        return $this->render('lieu/list.html.twig', [
            'type' => ucfirst($type), // Affiche le type sous un format utilisateur
            'lieux' => $lieux,
        ]);
    }

    #[Route('/lieu/{id}', name: 'lieu_detail')]
    public function detail(int $id): Response
    {
        $lieu = $this->lieuRepository->find($id);

        if (!$lieu) {
            throw $this->createNotFoundException('Lieu introuvable');
        }

        return $this->render('lieu/detail.html.twig', [
            'lieu' => $lieu,
        ]);
    }
}
