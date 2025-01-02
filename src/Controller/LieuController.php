<?php

namespace App\Controller;

use App\Repository\LieuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LieuController extends AbstractController
{
    #[Route('/lieux-culturels', name: 'lieu_culturel')]
    public function listCulturels(LieuRepository $lieuRepository): Response
    {
        $lieux = $lieuRepository->findByType('Culturel');

        if (empty($lieux)) {
            $this->addFlash('warning', 'Aucun lieu culturel trouvé.');
        }

        return $this->render('lieu/lieu_culturel.html.twig', [
            'lieux' => $lieux,
        ]);
    }

    #[Route('/lieux-naturels', name: 'lieu_naturel')]
    public function listNaturels(LieuRepository $lieuRepository): Response
    {
        $lieux = $lieuRepository->findByType('Naturel');

        if (empty($lieux)) {
            $this->addFlash('warning', 'Aucun lieu naturel trouvé.');
        }

        return $this->render('lieu/lieu_naturel.html.twig', [
            'lieux' => $lieux,
        ]);
    }

    #[Route('/lieux-vip', name: 'lieu_vip')]
    public function listVIP(LieuRepository $lieuRepository): Response
    {
        $lieux = $lieuRepository->findByType('VIP');

        if (empty($lieux)) {
            $this->addFlash('warning', 'Aucun lieu VIP trouvé.');
        }

        return $this->render('lieu/lieu_vip.html.twig', [
            'lieux' => $lieux,
        ]);
    }

    #[Route('/lieu/{id}', name: 'lieu_detail')]
    public function detail(int $id, LieuRepository $lieuRepository): Response
    {
        $lieu = $lieuRepository->find($id);

        if (!$lieu) {
            throw $this->createNotFoundException('Lieu introuvable');
        }

        return $this->render('lieu/detail.html.twig', [
            'lieu' => $lieu,
        ]);
    }
}
