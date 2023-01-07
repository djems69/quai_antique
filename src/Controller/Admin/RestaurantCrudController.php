<?php

namespace App\Controller\Admin;

use App\Entity\Restaurant;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;

class RestaurantCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Restaurant::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            /*TextField::new('name'),
            TextField::new('address'),*/
            NumberField::new('capacity'),
            TimeField::new('Opening_Time'),
            TimeField::new('Closing_Time'),
            DateField::new('day'),
            TextField::new('days_of_the_week')
        ];
    }
}
