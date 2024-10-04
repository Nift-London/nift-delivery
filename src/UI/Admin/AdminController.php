<?php

declare(strict_types=1);

namespace App\UI\Admin;

use App\Order\Domain\Entity\DeliveryOrder;
use App\Quote\Domain\Entity\Quote;
use App\Store\Domain\Entity\Location;
use App\Store\Domain\Entity\Store;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;

#[AsController]
final class AdminController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin_index')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(StoreCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('NFIT Delivery Admin - Dashboard');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),

            MenuItem::linkToCrud('Stores', 'fa fa-store', Store::class),
            MenuItem::linkToCrud('Locations', 'fa fa-map-pin', Location::class),
            MenuItem::linkToCrud('Quotes', 'fa fa-box', Quote::class),
            MenuItem::linkToCrud('Orders', 'fa fa-truck-fast', DeliveryOrder::class),
        ];
    }
}
