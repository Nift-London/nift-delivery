<?php

namespace App\UI\Admin;

use App\Quote\Domain\Entity\Quote;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;

class QuoteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Quote::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            IdField::new('groupId'),
            IdField::new('externalId')->hideOnIndex(),
            DateTimeField::new('createdAt'),
            IdField::new('pickupStreet')->hideOnIndex(),
            IdField::new('pickupPostalCode')->hideOnIndex(),
            IdField::new('pickupCity')->hideOnIndex(),
            IdField::new('deliveryStreet')->hideOnIndex(),
            IdField::new('deliveryPostalCode')->hideOnIndex(),
            IdField::new('deliveryCity')->hideOnIndex(),
            DateTimeField::new('pickupDateFrom')->hideOnIndex(),
            DateTimeField::new('pickupDateTo')->hideOnIndex(),
            DateTimeField::new('deliveryDateFrom')->hideOnIndex(),
            DateTimeField::new('deliveryDateTo'),
            ChoiceField::new('type')->hideOnIndex(),
            MoneyField::new('price')->setCurrency('GBP'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_INDEX, Action::EDIT)
            ->remove(Crud::PAGE_INDEX, Action::DELETE)
            ->remove(Crud::PAGE_DETAIL, Action::EDIT)
            ->remove(Crud::PAGE_DETAIL, Action::DELETE)
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
}
