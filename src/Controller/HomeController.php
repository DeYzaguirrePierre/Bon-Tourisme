<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Repository\LieuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Récupère tous les lieux
        $lieux = $entityManager->getRepository(Lieu::class)->findBy([]);

        // Mélange et limite à 10 éléments
        shuffle($lieux);
        $lieux = array_slice($lieux, 0, 10);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'Bon-Tourisme',
            'lieux' => $lieux, // Transmettre "lieux"
        ]);
    }
}
