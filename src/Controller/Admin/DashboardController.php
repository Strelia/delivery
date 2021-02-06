<?php

namespace App\Controller\Admin;

use App\Entity\Admin;
use App\Entity\Adr;
use App\Entity\Business;
use App\Entity\CarBodyKind;
use App\Entity\Cargo;
use App\Entity\LoadingKind;
use App\Entity\PackagingKind;
use App\Entity\RoadTrainKind;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Menu\SubMenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Delivery')
            // the name visible to end users
            // you can include HTML contents too (e.g. to link to an image)
//            ->setTitle('<img src="..."> ACME <span class="text-small">Corp.</span>')

            // the path defined in this method is passed to the Twig asset() function
//            ->setFaviconPath('favicon.svg')

            // the domain used by default is 'messages'
            ->setTranslationDomain('messages')

            // there's no need to define the "text direction" explicitly because
            // its default value is inferred dynamically from the user locale
            ->setTextDirection('ltr')

            // set this option if you prefer the page content to span the entire
            // browser width, instead of the default design which sets a max width
            ->renderContentMaximized()

            // set this option if you prefer the sidebar (which contains the main menu)
            // to be displayed as a narrow column instead of the default expanded design
            ->renderSidebarMinimized()

            // by default, all backend URLs include a signature hash. If a user changes any
            // query parameter (to "hack" the backend) the signature won't match and EasyAdmin
            // triggers an error. If this causes any issue in your backend, call this method
            // to disable this feature and remove all URL signature checks
            ->disableUrlSignatures();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('menu.admins', 'fa fa-user-shield', User::class)
            ->setController(AdminCrudController::class);
        yield MenuItem::linkToCrud('menu.users', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('menu.businesses', 'fas fa-business-time', Business::class);
        yield MenuItem::subMenu('menu.kinds', 'fas fa-layer-group')->setSubItems([
            MenuItem::linkToCrud('menu.adr', 'fas fa-radiation', Adr::class),
            MenuItem::linkToCrud('menu.car-body', 'fas fa-car', CarBodyKind::class),
            MenuItem::linkToCrud('menu.road-train', 'fas fa-trailer', RoadTrainKind::class),
            MenuItem::linkToCrud('menu.loading', 'fas fa-truck-loading', LoadingKind::class),
            MenuItem::linkToCrud('menu.packaging', 'fas fa-box', PackagingKind::class),
        ]);
        yield MenuItem::linkToCrud('menu.cargo', 'fas fa-boxes', Cargo::class);
    }
}
