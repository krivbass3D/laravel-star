<?php

namespace App\Services;

use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getCatalogProducts(array $filters = [], int $perPage = 12)
    {
        $products = $this->productRepository->getAllWithPagination($filters, $perPage);
        
        // Трансформация цен в евро
        $products->getCollection()->transform(function ($product) {
            $product->price = round($product->price / 100, 2);
            // Используем загруженное изображение, если оно есть и существует
            if ($product->image && file_exists(public_path('storage/' . $product->image))) {
                $product->image = asset('storage/' . $product->image);
            } else {
                $product->image = "https://picsum.photos/300/200?random=" . $product->id;
            }
            return $product;
        });

        return $products;
    }

    public function getPriceRange()
    {
        $priceRange = $this->productRepository->getPriceRange();
        return [
            'min' => round($priceRange->min_price / 100, 2),
            'max' => round($priceRange->max_price / 100, 2)
        ];
    }

    public function createProduct(array $data)
    {
        // Конвертация цены в копейки
        if (isset($data['price'])) {
            $data['price'] = $data['price'] * 100;
        }
        
        return $this->productRepository->create($data);
    }

    public function updateProduct(int $id, array $data)
    {
        // Конвертация цены в копейки
        if (isset($data['price'])) {
            $data['price'] = $data['price'] * 100;
        }

        return $this->productRepository->update($id, $data);
    }

    public function deleteProduct(int $id)
    {
        return $this->productRepository->delete($id);
    }
} 