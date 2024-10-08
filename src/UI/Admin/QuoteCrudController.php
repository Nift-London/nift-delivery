<?php

namespace App\UI\Admin;

use App\Order\Domain\Entity\DeliveryOrder;
use App\Quote\Domain\Entity\Quote;
use App\Quote\Domain\Enum\QuoteTypeEnum;
use App\Store\Domain\Entity\Location;
use App\Store\Domain\Entity\Store;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class QuoteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Quote::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('location')
                ->formatValue(function (Location $val) {
                    return $val->getStore()->getName() . ' - ' . $val->getName();
                }),
            ChoiceField::new('type')->hideOnIndex(),
            TextField::new('externalId')->hideOnIndex(),
            DateTimeField::new('createdAt'),
            ChoiceField::new('type')->formatValue(function (QuoteTypeEnum $val) {
                return $val->value;
            }),
            TextField::new('deliveryStreet')->hideOnIndex(),
            TextField::new('deliveryPostalCode')->hideOnIndex(),
            TextField::new('deliveryCity')->hideOnIndex(),
            DateTimeField::new('pickupDateFrom')->hideOnIndex(),
            DateTimeField::new('pickupDateTo')->hideOnIndex(),
            DateTimeField::new('deliveryDateFrom')->hideOnIndex(),
            DateTimeField::new('deliveryDateTo'),
            MoneyField::new('price')->setCurrency('GBP'),
            MoneyField::new('customerPrice')->setCurrency('GBP'),
            AssociationField::new('deliveryOrder')
                ->formatValue(function (?DeliveryOrder $val) {
                    return is_null($val) ? '-' : '<i class="fa-solid fa-truck-fast"></i>';
                }),
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

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['createdAt' => 'DESC']);
    }
}
