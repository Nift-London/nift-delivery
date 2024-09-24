<?php

namespace App\UI\Admin;

use App\Store\Domain\Entity\Store;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class StoreCrudController extends AbstractCrudController
{
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
            TextField::new('shopifyToken')->hideOnIndex()->setHelp('Shopify API token'),
            TextField::new('shopifyName')->hideOnIndex()->setHelp('Shopify store name, part of the URL (e.g. "my-store" for "my-store.myshopify.com")'),
            TextField::new('shopifyDomain')->hideOnIndex()->setHelp('Shopify store domain (e.g. "my-store.myshopify.com")'),
            AssociationField::new('locations')
        ];
    }
}
