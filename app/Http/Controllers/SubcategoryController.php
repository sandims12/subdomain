<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubcategoryController extends Controller
{
    // Menampilkan daftar subkategori
    public function index()
    {
        // Ambil semua subkategori dengan relasi kategori
        $subcategories = Subcategory::with('category')->latest()->get();
        return view('admin.subcategories.index', compact('subcategories'));
    }

    // Menampilkan form untuk menambah subkategori
    public function create()
    {
        // Ambil semua kategori untuk dropdown
        $categories = Category::all();
        return view('admin.subcategories.create', compact('categories'));
    }

    // Menyimpan subkategori baru
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255|unique:subcategories,name',
        ]);

        Subcategory::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
        ]);

        return redirect()->route('admin.subcategories.index')->with('success', 'Subkategori berhasil dibuat!');
    }

    // Menampilkan form untuk mengedit subkategori
    public function edit($categoryId, $subcategoryId)
    {
        $category = Category::findOrFail($categoryId);
        $subcategory = Subcategory::findOrFail($subcategoryId);

        return view('admin.subcategories.edit', compact('subcategory', 'category'));
    }

    // Mengupdate subkategori
    public function update(Request $request, $categoryId, $subcategoryId)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:subcategories,name,' . $subcategoryId,
        ]);

        $subcategory = Subcategory::findOrFail($subcategoryId);
        $subcategory->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.subcategories.index', $categoryId)->with('success', 'Subkategori berhasil diperbarui!');
    }

    // Menghapus subkategori
    public function destroy($categoryId, $subcategoryId)
    {
        $subcategory = Subcategory::findOrFail($subcategoryId);
        $subcategory->delete();

        return redirect()->route('admin.subcategories.index', $categoryId)->with('success', 'Subkategori berhasil dihapus!');
    }

    public function getSubcategories($categoryId)
{
    // Mengambil subkategori berdasarkan kategori_id
    $subcategories = Subcategory::where('category_id', $categoryId)->get();

    // Mengembalikan subkategori dalam bentuk JSON
    return response()->json(['subcategories' => $subcategories]);
}

}