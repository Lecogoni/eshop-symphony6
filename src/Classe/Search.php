<?php
# class créer pour la mécanique de filter sur les products

namespace App\Classe;

use App\Entity\Category;

class Search
{
    # propriété pour rechercher un product par son nom, mis en public afin d'éviter la création de getter / setter
    /**
     * @var string
     */
    public $string = '';

    /**
     * @var Category[]
     */
    public $categories = [];
}