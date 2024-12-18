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
        // Récupère tous les lieux depuis le repository
        $lieux = $lieuRepository->findAll();

        // Vérification des données
        if (empty($lieux)) {
            $this->addFlash('warning', 'Aucun lieu culturel trouvé.');
        }

        // Passe les données à la vue
        return $this->render('lieu/lieu_culturel.html.twig', [
            'lieux' => $lieux, // Variable "lieux" pour le template
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
