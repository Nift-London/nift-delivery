<?php

declare(strict_types=1);

namespace App\UI\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;

#[AsController]
final class AdminController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin_index', methods: ['GET'])]
    public function index(): Response
    {
        return parent::index();
    }
}
