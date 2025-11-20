<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    // List
    public function index()
    {
        $subcategories = Subcategory::with('category')->latest()->get();
        return view('admin.subcategories.index', compact('subcategories'));
    }

    // Create
    public function create()
    {
        $categories = Category::all();
        return view('admin.subcategories.create', compact('categories'));
    }

    // Store
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required','exists:categories,id'],
            'name'        => ['required','string','max:255','unique:subcategories,name'],
        ]);

        Subcategory::create($validated);

        return redirect()
            ->route('admin.subcategories.index')
            ->with('success', 'Subkategori berhasil dibuat!');
    }

    // ✅ Edit (1 parameter saja – pakai route model binding)
    public function edit(Subcategory $subcategory)
    {
        $categories = Category::all();
        return view('admin.subcategories.edit', compact('subcategory','categories'));
    }

    // ✅ Update (1 parameter saja)
    public function update(Request $request, Subcategory $subcategory)
    {
        $validated = $request->validate([
            'category_id' => ['required','exists:categories,id'],
            'name'        => ['required','string','max:255','unique:subcategories,name,' . $subcategory->id],
        ]);

        $subcategory->update($validated);

        return redirect()
            ->route('admin.subcategories.index')
            ->with('success', 'Subkategori berhasil diperbarui!');
    }

    // ✅ Destroy (1 parameter saja)
    public function destroy(Subcategory $subcategory)
    {
        $subcategory->delete();

        return redirect()
            ->route('admin.subcategories.index')
            ->with('success', 'Subkategori berhasil dihapus!');
    }

    // AJAX: ambil subkategori per category
    public function getSubcategories($categoryId)
    {
        $subcategories = Subcategory::where('category_id', $categoryId)->get();
        return response()->json(['subcategories' => $subcategories]);
    }
}
