<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CatalogController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['category', 'search', 'sort', 'min_price', 'max_price']);
        
        $products = $this->productService->getCatalogProducts($filters);
        $priceRange = $this->productService->getPriceRange();
        $categories = Category::with('products')->get();

        return Inertia::render('Catalog', [
            'categories' => $categories,
            'products' => $products,
            'filters' => $filters,
            'priceRange' => $priceRange
        ]);
    }
}
