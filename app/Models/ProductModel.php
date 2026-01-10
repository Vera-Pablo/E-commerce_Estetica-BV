<?php

namespace App\Models;

use CodeIgniter\Model;

use App\Models\Entities\Product;

class ProductModel extends Model{
    protected $table = 'products';
    protected $primaryKey = 'id_product';
    protected $useAutoIncrement = true;
    protected $returnType = Product::class;
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'id_product',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image',
        'is_active',
        'id_categories'
    ];

    // Custom method to get active products with optional filtering
    public function getActiveProducts($categoryId = null, $search = null){
        $builder = $this->where(['is_active' => 1, 'stock >' => 0]);

        if($categoryId){
            $builder->where('id_categories', $categoryId);
        }

        if($search){
            $builder->groupStart()
                    ->like('name', $search)
                    ->orLike('description', $search)
                    ->groupEnd();
        }

        return $builder->findAll();
    }

}