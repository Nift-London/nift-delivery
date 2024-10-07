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

            FormField::addColumn(4),
            IntegerField::new('todayMaxPrice')->hideOnIndex(),
            BooleanField::new('todayFirstDistanceEnabled')->hideOnIndex(),
            IntegerField::new('todayFirstDistanceFrom')->hideOnIndex(),
            IntegerField::new('todayFirstDistanceTo')->hideOnIndex(),
            IntegerField::new('todayFirstDistancePrice')->hideOnIndex(),
            BooleanField::new('todaySecondDistanceEnabled')->hideOnIndex(),
            IntegerField::new('todaySecondDistanceFrom')->hideOnIndex(),
            IntegerField::new('todaySecondDistanceTo')->hideOnIndex(),
            IntegerField::new('todaySecondDistancePrice')->hideOnIndex(),
            BooleanField::new('todayThirdDistanceEnabled')->hideOnIndex(),
            IntegerField::new('todayThirdDistanceFrom')->hideOnIndex(),
            IntegerField::new('todayThirdDistanceTo')->hideOnIndex(),
            IntegerField::new('todayThirdDistancePrice')->hideOnIndex(),
            BooleanField::new('todayFourthDistanceEnabled')->hideOnIndex(),
            IntegerField::new('todayFourthDistanceFrom')->hideOnIndex(),
            IntegerField::new('todayFourthDistanceTo')->hideOnIndex(),
            IntegerField::new('todayFourthDistancePrice')->hideOnIndex(),
            BooleanField::new('todayFifthDistanceEnabled')->hideOnIndex(),
            IntegerField::new('todayFifthDistanceFrom')->hideOnIndex(),
            IntegerField::new('todayFifthDistanceTo')->hideOnIndex(),
            IntegerField::new('todayFifthDistancePrice')->hideOnIndex(),

            FormField::addColumn(4),
            IntegerField::new('tonightMaxPrice')->hideOnIndex(),
            BooleanField::new('tonightFirstDistanceEnabled')->hideOnIndex(),
            IntegerField::new('tonightFirstDistanceFrom')->hideOnIndex(),
            IntegerField::new('tonightFirstDistanceTo')->hideOnIndex(),
            IntegerField::new('tonightFirstDistancePrice')->hideOnIndex(),
            BooleanField::new('tonightSecondDistanceEnabled')->hideOnIndex(),
            IntegerField::new('tonightSecondDistanceFrom')->hideOnIndex(),
            IntegerField::new('tonightSecondDistanceTo')->hideOnIndex(),
            IntegerField::new('tonightSecondDistancePrice')->hideOnIndex(),
            BooleanField::new('tonightThirdDistanceEnabled')->hideOnIndex(),
            IntegerField::new('tonightThirdDistanceFrom')->hideOnIndex(),
            IntegerField::new('tonightThirdDistanceTo')->hideOnIndex(),
            IntegerField::new('tonightThirdDistancePrice')->hideOnIndex(),
            BooleanField::new('tonightFourthDistanceEnabled')->hideOnIndex(),
            IntegerField::new('tonightFourthDistanceFrom')->hideOnIndex(),
            IntegerField::new('tonightFourthDistanceTo')->hideOnIndex(),
            IntegerField::new('tonightFourthDistancePrice')->hideOnIndex(),
            BooleanField::new('tonightFifthDistanceEnabled')->hideOnIndex(),
            IntegerField::new('tonightFifthDistanceFrom')->hideOnIndex(),
            IntegerField::new('tonightFifthDistanceTo')->hideOnIndex(),
            IntegerField::new('tonightFifthDistancePrice')->hideOnIndex(),

            FormField::addColumn(4),
            IntegerField::new('tomorrowMaxPrice')->hideOnIndex(),
            BooleanField::new('tomorrowEnabled')->hideOnIndex(),
            IntegerField::new('tomorrowPrice')->hideOnIndex(),
        ];
    }
}
