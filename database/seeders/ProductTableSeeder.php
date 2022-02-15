<?php

namespace Database\Seeders;

use App\Models\Products;
use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    protected const PRODUCTS = [
        [
            'name' => 'macbook PRO',
            'price' => 2500,
            'image_url' => './assets/images/macbook.png'
        ],
        [
            'name' => 'iphone 13',
            'price' => 2700,
            'image_url' => './assets/images/iphone-13.png'
        ],
        [
            'name' => 'Omen O15',
            'price' => 2000,
            'image_url' => './assets/images/omen.png'
        ],

    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::PRODUCTS as $product){
            Products::create($product);
        }
    }
}
