<?php

namespace App\Models\Entities;

use CodeIgniter\Entity\Entity;

class Product extends Entity{
    protected $datamap = [];
    protected $dates = ['created_at', 'updated_at','deleted_at'];
    protected $casts = [];

    public function getImageUrl(){
        $img = $this->attributes['image'] ?? null;

        if (empty($img)) {
            return base_url('assets/images/banners/no_image.png');
        }

        if (strpos($img, 'http') === 0) {
            return $img;
        }

        return base_url('images/products/' . $img);
    }

    public function getFormattedPrice(){
        return '$' . number_format($this->attributes['price'], 2, ',' , '.');
    }
}

