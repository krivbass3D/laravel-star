<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Product::with('category');
        
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        $categories = \App\Models\Category::with('products')->get();
        $products = $query->paginate(12);

        // Конвертируем цены в евро (1 евро = 100 рублей)
        $products->getCollection()->transform(function ($product) {
            $product->price = round($product->price / 100, 2);
            // Добавляем заглушки для изображений в зависимости от категории
            $categoryColors = [
                'electronics' => '2563eb',
                'clothing' => 'dc2626',
                'home-and-garden' => '059669',
                'beauty-and-health' => '7c3aed',
                'sports-and-outdoor' => 'f59e0b',
                'books-and-stationery' => '6366f1',
                'kids' => 'ec4899',
                'auto' => '475569',
                'pets' => '84cc16',
                'food' => 'f97316'
            ];
            
            $slug = $product->category->slug ?? 'default';
            $color = $categoryColors[$slug] ?? 'gray';
            $product->image = "https://picsum.photos/300/200?random=" . $product->id;
            
            return $product;
        });

        return Inertia::render('Catalog', [
            'categories' => $categories,
            'products' => $products,
            'filters' => $request->only(['category'])
        ]);
    }
}
