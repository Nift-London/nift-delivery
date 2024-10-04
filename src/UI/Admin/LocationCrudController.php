<?php

namespace App\UI\Admin;

use App\Store\Domain\Entity\Location;
use App\Store\Domain\Entity\Store;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class LocationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Location::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab('Location settings'),
            FormField::addColumn(6),
            TextField::new('name'),
            DateTimeField::new('createdAt')->setFormTypeOption('disabled','disabled')->hideWhenCreating(),
            TextField::new('street'),
            TextField::new('postalCode'),
            TextField::new('city'),
            BooleanField::new('enabled'),
            TextField::new('evermileLocationId')->hideOnIndex(),
            AssociationField::new('store')
                ->formatValue(function (?Store $val) {
                    return $val->getName();
                }),

            FormField::addTab('Pricing settings'),
            BooleanField::new('tonightEnabled')->hideOnIndex(),
            IntegerField::new('tonightPrice')->hideOnIndex(),
            BooleanField::new('todayEnabled')->hideOnIndex(),
            IntegerField::new('todayPrice')->hideOnIndex(),
            BooleanField::new('tomorrowEnabled')->hideOnIndex(),
            IntegerField::new('tomorrowPrice')->hideOnIndex(),
        ];
    }
}
