<?php

namespace App\UI\Admin;

use App\Store\Domain\Entity\Store;
use App\Store\Infrastructure\Command\SyncLocationsCommand;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class StoreCrudController extends AbstractCrudController
{
    private SyncLocationsCommand $syncLocationsCommand;

    public function __construct(SyncLocationsCommand $syncLocationsCommand)
    {
        $this->syncLocationsCommand = $syncLocationsCommand;
    }

    public function configureActions(Actions $actions): Actions
    {
        $syncLocations = Action::new('syncLocations', 'Sync Locations', 'fa fa-file-invoice')
            ->linkToCrudAction('syncLocations');

        return $actions
            ->add(Crud::PAGE_EDIT, $syncLocations)
            ->add(Crud::PAGE_DETAIL, $syncLocations);
    }

    public static function getEntityFqcn(): string
    {
        return Store::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            DateTimeField::new('createdAt')->setFormTypeOption('disabled','disabled')->hideWhenCreating(),
            BooleanField::new('enabled'),
            TextField::new('shopifyClientId')->hideOnIndex()->setHelp('Shopify API token'),
            TextField::new('shopifyClientSecret')->hideOnIndex()->setHelp('Shopify API token'),
            TextField::new('shopifyAuthCode')->hideOnIndex()->setHelp('Shopify API token'),
            TextField::new('shopifyToken')->hideOnIndex()->setHelp('Shopify API token'),
            TextField::new('shopifyName')->hideOnIndex()->setHelp('Shopify store name, part of the URL (e.g. "my-store" for "my-store.myshopify.com")'),
            TextField::new('shopifyDomain')->hideOnIndex()->setHelp('Shopify store domain (e.g. "my-store.myshopify.com")'),
            AssociationField::new('locations')
        ];
    }

    public function syncLocations(AdminContext $context)
    {
        /** @var Store $store */
        $store = $context->getEntity()->getInstance();
        $this->syncLocationsCommand->sync($store);

        return $this->redirect($this->container->get(AdminUrlGenerator::class)
            ->setAction(Action::DETAIL)
            ->setEntityId($store->getId())
            ->generateUrl());
    }
}
