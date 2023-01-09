<?php

namespace App\Controller\Admin;

use App\Entity\Restaurant;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
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

            NumberField::new('capacity'),
            TimeField::new('Opening_Time'),
            TimeField::new('Closing_Time'),
            TimeField::new('Opening_Time_Noon'),
            TimeField::new('Closing_Time_Noon')
        ];
    }
}
