<?php
namespace App\Http\Controllers;

use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::all();
    }

    // TODO: route model binding toepassen
    public function show($id)
    {
        // TODO: resources gebruiken
        return Category::findOrFail($id);
    }

    public function store(Request $request)
    {
        // TODO: form validation classes gebruiken
        $this->authorize('create', Category::class);
        
        $category = Category::create($request->validate([
            'title' => 'required|string|max:255',
        ]));
        return response()->json($category, 201);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $this->authorize('update', $category);
        $category->update($request->validated());

        return new CategoryResource($category);
    }

    public function destroy($id)
    {
        Category::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
