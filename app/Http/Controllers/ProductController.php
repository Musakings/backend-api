<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Services\ProductService;

class ProductController extends Controller
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Menampilkan semua produk
     */
    public function index()
    {
        try {
            $products = $this->productService->getProducts();

            return response()->json([
                'data' => $products
            ], 200);

        } catch (\Exception $e) {

            Log::error('Terjadi kesalahan saat mengambil produk', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'message' => 'Terjadi kesalahan pada server'
            ], 500);
        }
    }

    /**
     * Menambahkan produk baru
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {

            return response()->json([
                'message' => 'Data yang dikirim tidak valid',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Ambil data yang sudah tervalidasi
            $validated = $validator->validated();

            // Simpan produk
            $product = $this->productService->createProduct($validated);

            // Catat aktivitas
            Log::info('Produk baru ditambahkan', $product->toArray());

            return response()->json([
                'message' => 'Produk berhasil ditambahkan',
                'data' => $product
            ], 201);

        } catch (\Exception $e) {

            Log::error('Terjadi kesalahan saat menambahkan produk', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'message' => 'Terjadi kesalahan pada server'
            ], 500);
        }
    }

    /**
     * Memperbarui produk
     */
    public function update(Request $request, Product $product)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {

            return response()->json([
                'message' => 'Data yang dikirim tidak valid',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Ambil data yang sudah tervalidasi
            $validated = $validator->validated();

            // Update produk
            $updatedProduct = $this->productService->updateProduct(
                $product,
                $validated
            );

            // Catat aktivitas
            Log::info(
                'Produk berhasil diperbarui',
                $updatedProduct->toArray()
            );

            return response()->json([
                'message' => 'Produk berhasil diperbarui',
                'data' => $updatedProduct
            ], 200);

        } catch (\Exception $e) {

            Log::error(
                'Terjadi kesalahan saat memperbarui produk',
                [
                    'error' => $e->getMessage()
                ]
            );

            return response()->json([
                'message' => 'Terjadi kesalahan pada server'
            ], 500);
        }
    }

    /**
     * Menghapus produk
     */
    public function destroy(Product $product)
    {
        try {
            $productId = $product->id;

            // Hapus produk
            $this->productService->deleteProduct($product);

            // Catat aktivitas
            Log::info('Produk berhasil dihapus', [
                'id' => $productId
            ]);

            return response()->json([
                'message' => 'Produk berhasil dihapus'
            ], 200);

        } catch (\Exception $e) {

            Log::error(
                'Terjadi kesalahan saat menghapus produk',
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