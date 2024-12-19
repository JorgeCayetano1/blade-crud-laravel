<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::latest()->paginate(5);

        return view('products.index', compact('products'))
                    ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create(): View
    {
        return view('products.create');
    }

    public function store(ProductStoreRequest $request): RedirectResponse
    {
        Product::create($request->validated());

        return redirect()->route('products.index')
                        ->with('success', 'Product created successfully.');
    }

    public function show(Product $product): View
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product): View
    {
        return view('products.edit', compact('product'));
    }

    public function update(ProductStoreRequest $request, Product $product): RedirectResponse
    {
        $product->update($request->validated());

        return redirect()->route('products.index')
                        ->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('products.index')
                        ->with('success', 'Product deleted successfully');
    }


}
