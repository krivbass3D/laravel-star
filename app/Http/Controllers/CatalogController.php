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

        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price * 100);
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price * 100);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_low':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $categories = \App\Models\Category::with('products')->get();
        $products = $query->paginate(12);

        $priceRange = \App\Models\Product::selectRaw('MIN(price) as min_price, MAX(price) as max_price')->first();

        $products->getCollection()->transform(function ($product) {
            $product->price = round($product->price / 100, 2);
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
            'filters' => $request->only(['category', 'search', 'sort', 'min_price', 'max_price']),
            'priceRange' => [
                'min' => round($priceRange->min_price / 100, 2),
                'max' => round($priceRange->max_price / 100, 2)
            ]
        ]);
    }
}
