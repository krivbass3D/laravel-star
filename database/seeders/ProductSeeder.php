<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        // Электроника
        for ($i = 1; $i <= 50; $i++) {
            \App\Models\Product::create([
                'name' => $faker->words(3, true) . ' ' . $faker->randomElement(['Смартфон', 'Ноутбук', 'Планшет', 'Наушники', 'Колонка', 'Часы', 'Фитнес-браслет']),
                'slug' => 'electronics-' . $i,
                'description' => $faker->paragraph(3),
                'price' => $faker->randomFloat(2, 100, 2000),
                'category_id' => 1,
                'image' => 'electronics-' . $i . '.jpg'
            ]);
        }

        // Одежда
        for ($i = 1; $i <= 50; $i++) {
            \App\Models\Product::create([
                'name' => $faker->words(2, true) . ' ' . $faker->randomElement(['Футболка', 'Джинсы', 'Платье', 'Куртка', 'Рубашка', 'Юбка', 'Свитер']),
                'slug' => 'clothing-' . $i,
                'description' => $faker->paragraph(3),
                'price' => $faker->randomFloat(2, 20, 500),
                'category_id' => 2,
                'image' => 'clothing-' . $i . '.jpg'
            ]);
        }

        // Дом и сад
        for ($i = 1; $i <= 50; $i++) {
            \App\Models\Product::create([
                'name' => $faker->words(2, true) . ' ' . $faker->randomElement(['Стул', 'Стол', 'Диван', 'Шкаф', 'Кровать', 'Лампа', 'Горшок']),
                'slug' => 'home-' . $i,
                'description' => $faker->paragraph(3),
                'price' => $faker->randomFloat(2, 50, 2000),
                'category_id' => 3,
                'image' => 'home-' . $i . '.jpg'
            ]);
        }

        // Красота и здоровье
        for ($i = 1; $i <= 50; $i++) {
            \App\Models\Product::create([
                'name' => $faker->words(2, true) . ' ' . $faker->randomElement(['Крем', 'Шампунь', 'Духи', 'Маска', 'Сыворотка', 'Гель', 'Скраб']),
                'slug' => 'beauty-' . $i,
                'description' => $faker->paragraph(3),
                'price' => $faker->randomFloat(2, 10, 200),
                'category_id' => 4,
                'image' => 'beauty-' . $i . '.jpg'
            ]);
        }

        // Спорт и отдых
        for ($i = 1; $i <= 50; $i++) {
            \App\Models\Product::create([
                'name' => $faker->words(2, true) . ' ' . $faker->randomElement(['Мяч', 'Ракетка', 'Гантели', 'Велосипед', 'Скейтборд', 'Ролики', 'Тренажер']),
                'slug' => 'sports-' . $i,
                'description' => $faker->paragraph(3),
                'price' => $faker->randomFloat(2, 30, 1000),
                'category_id' => 5,
                'image' => 'sports-' . $i . '.jpg'
            ]);
        }

        // Книги и канцелярия
        for ($i = 1; $i <= 50; $i++) {
            \App\Models\Product::create([
                'name' => $faker->words(3, true) . ' ' . $faker->randomElement(['Книга', 'Тетрадь', 'Ручка', 'Карандаш', 'Блокнот', 'Альбом', 'Краски']),
                'slug' => 'books-' . $i,
                'description' => $faker->paragraph(3),
                'price' => $faker->randomFloat(2, 5, 100),
                'category_id' => 6,
                'image' => 'books-' . $i . '.jpg'
            ]);
        }

        // Детские товары
        for ($i = 1; $i <= 50; $i++) {
            \App\Models\Product::create([
                'name' => $faker->words(2, true) . ' ' . $faker->randomElement(['Игрушка', 'Конструктор', 'Кукла', 'Машинка', 'Пазл', 'Книжка', 'Коляска']),
                'slug' => 'kids-' . $i,
                'description' => $faker->paragraph(3),
                'price' => $faker->randomFloat(2, 10, 300),
                'category_id' => 7,
                'image' => 'kids-' . $i . '.jpg'
            ]);
        }

        // Автотовары
        for ($i = 1; $i <= 50; $i++) {
            \App\Models\Product::create([
                'name' => $faker->words(2, true) . ' ' . $faker->randomElement(['Масло', 'Фильтр', 'Аккумулятор', 'Шины', 'Диски', 'Фара', 'Зеркало']),
                'slug' => 'auto-' . $i,
                'description' => $faker->paragraph(3),
                'price' => $faker->randomFloat(2, 50, 1000),
                'category_id' => 8,
                'image' => 'auto-' . $i . '.jpg'
            ]);
        }

        // Зоотовары
        for ($i = 1; $i <= 50; $i++) {
            \App\Models\Product::create([
                'name' => $faker->words(2, true) . ' ' . $faker->randomElement(['Корм', 'Игрушка', 'Ошейник', 'Миска', 'Лежанка', 'Шампунь', 'Поводок']),
                'slug' => 'pets-' . $i,
                'description' => $faker->paragraph(3),
                'price' => $faker->randomFloat(2, 5, 200),
                'category_id' => 9,
                'image' => 'pets-' . $i . '.jpg'
            ]);
        }

        // Продукты питания
        for ($i = 1; $i <= 50; $i++) {
            \App\Models\Product::create([
                'name' => $faker->words(2, true) . ' ' . $faker->randomElement(['Чай', 'Кофе', 'Печенье', 'Шоколад', 'Сок', 'Вода', 'Снеки']),
                'slug' => 'food-' . $i,
                'description' => $faker->paragraph(3),
                'price' => $faker->randomFloat(2, 1, 50),
                'category_id' => 10,
                'image' => 'food-' . $i . '.jpg'
            ]);
        }
    }
}
