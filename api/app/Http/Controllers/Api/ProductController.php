<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Interface\Service\ProductServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    private $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 10);
        $products = $this->productService->getAllProducts()->paginate($perPage);
        return response()->json(['products' => $products], 200);
    }

    public function store(ProductStoreRequest $request): JsonResponse
    {
        $product = $this->productService->createProduct($request->validated());
        return response()->json(['product' => $product], 201);
    }

    public function show(int $id): JsonResponse
    {
        try {
            $product = $this->productService->getProductById($id);
            return response()->json(['product' => $product], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function update(ProductUpdateRequest $request, int $id): JsonResponse
    {
        try {
            $requestData = (object) $request->validated();
            $product = $this->productService->updateProduct($id, $requestData);
            return response()->json(['product' => $product], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $result = $this->productService->deleteProduct($id);
            return response()->json(['message' => 'Product soft deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }
}
