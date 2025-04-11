<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Электроника',
                'slug' => 'electronics',
                'description' => 'Электронные устройства и гаджеты'
            ],
            [
                'name' => 'Одежда',
                'slug' => 'clothing',
                'description' => 'Модная одежда и аксессуары'
            ],
            [
                'name' => 'Дом и сад',
                'slug' => 'home-and-garden',
                'description' => 'Товары для дома и сада'
            ],
            [
                'name' => 'Красота и здоровье',
                'slug' => 'beauty-and-health',
                'description' => 'Косметика, парфюмерия и товары для здоровья'
            ],
            [
                'name' => 'Спорт и отдых',
                'slug' => 'sports-and-outdoor',
                'description' => 'Спортивные товары и снаряжение'
            ],
            [
                'name' => 'Книги и канцелярия',
                'slug' => 'books-and-stationery',
                'description' => 'Книги, учебники и канцелярские товары'
            ],
            [
                'name' => 'Детские товары',
                'slug' => 'kids',
                'description' => 'Товары для детей и игрушки'
            ],
            [
                'name' => 'Автотовары',
                'slug' => 'auto',
                'description' => 'Автомобильные аксессуары и запчасти'
            ],
            [
                'name' => 'Зоотовары',
                'slug' => 'pets',
                'description' => 'Товары для домашних животных'
            ],
            [
                'name' => 'Продукты питания',
                'slug' => 'food',
                'description' => 'Продукты питания и напитки'
            ]
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }
}
