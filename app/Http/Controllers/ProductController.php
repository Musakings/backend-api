<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Models\Product;
use App\Services\ProductService;

class ProductController extends Controller
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = $this->productService->getProducts();

        return response()->json([
            'data' => $products
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
            ]);

            $product = $this->productService->createProduct($validated);

            Log::info('Produk baru ditambahkan', $product->toArray());

            return response()->json([
                'message' => 'Produk berhasil ditambahkan',
                'data' => $product
            ], 201);

        } catch (ValidationException $e) {

            return response()->json([
                'message' => 'Data yang dikirim tidak valid',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {

            Log::error('Terjadi Kesalahan', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'message' => 'Terjadi kesalahan pada server'
            ], 500);
        }
    }

    public function update(Request $request, Product $product)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
            ]);

            $updatedProduct = $this->productService->updateProduct(
                $product,
                $validated
            );

            Log::info(
                'Produk berhasil diperbarui',
                $updatedProduct->toArray()
            );

            return response()->json([
                'message' => 'Produk berhasil diperbarui',
                'data' => $updatedProduct
            ]);

        } catch (ValidationException $e) {

            return response()->json([
                'message' => 'Data yang dikirim tidak valid',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {

            Log::error(
                'Terjadi Kesalahan saat memperbarui produk',
                [
                    'error' => $e->getMessage()
                ]
            );

            return response()->json([
                'message' => 'Terjadi kesalahan pada server'
            ], 500);
        }
    }

    public function destroy(Product $product)
    {
        try {
            $productId = $product->id;

            $this->productService->deleteProduct($product);

            Log::info('Produk berhasil dihapus', [
                'id' => $productId
            ]);

            return response()->json([
                'message' => 'Produk berhasil dihapus'
            ]);

        } catch (\Exception $e) {

            Log::error(
                'Terjadi Kesalahan saat menghapus produk',
                [
                    'error' => $e->getMessage()
                ]
            );

            return response()->json([
                'message' => 'Terjadi kesalahan pada server'
            ], 500);
        }
    }
}