<?php

namespace App\Controller\Admin;

use App\Entity\Avis;
use App\Entity\Lieu;
use App\Entity\User;
use App\Entity\TypeLieu;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // Générer l'URL pour un CRUD existant (ex : UserCrudController)
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        $url = $adminUrlGenerator->setController(UserCrudController::class)->generateUrl();

        // Rediriger vers l'URL générée
        return $this->redirect($url);
    }
    // public function index(): Response
    // {
    //     // return parent::index();

    //     // Option 1. You can make your dashboard redirect to some common page of your backend
    //     //
    //     $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
    //     return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());

    //     // Option 2. You can make your dashboard redirect to different pages depending on the user
    //     //
    //     // if ('jane' === $this->getUser()->getUsername()) {
    //     //     return $this->redirect('...');
    //     // }

    //     // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
    //     // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
    //     //
    //     // return $this->render('some/path/my-dashboard.html.twig');
    // }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Bon Tourisme');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-users', User::class);
        yield MenuItem::linkToCrud('Lieu', 'fa fa-map-marker', Lieu::class);
        yield MenuItem::linkToCrud('Type Lieu', 'fas fa-tags', TypeLieu::class);
        yield MenuItem::linkToCrud('Avis', 'fa-solid fa-comment', Avis::class);
    }
}
