<?php

namespace App\Models;
use CodeIgniter\Model;
use App\Models\Entities\Category;

class CategoryModel extends model{
    protected $table = 'categories';
    protected $primaryKey = 'id_categorie'; 
    protected $useAutoIncrement = true;
    protected $returnType = Category::class;
    protected$useSoftDeletes = false;
    protected $allowedFields = ['name', 'slug', 'description', 'is_active']; 
    protected $useTimestamps = false;

    
    public function getCategoriesForMenu(){
        return $this->findAll();
    }
}