<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name');
        yield ImageField::new('illustration')
            ->setBasePath('uploads')
            ->setUploadDir('public/uploads')
            ->setUploadedFileNamePattern('[slug].[randomhash].[extension]')
            ->setRequired(false);
        yield TextField::new('subtitle');
        yield TextareaField::new('description')->setNumOfRows(5);
        yield SlugField::new('slug')->setTargetFieldName('name');
        yield MoneyField::new('price')->setCurrency('EUR');
        yield AssociationField::new('category');
    } 
}
    