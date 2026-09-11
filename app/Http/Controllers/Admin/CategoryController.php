<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::with('parent')
            ->orderByDesc('id')
            ->paginate(15);

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('title')->get();

        return view('admin.categories.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'     => 'required|string|max:255',
            'slug'      => 'nullable|string|max:255|unique:categories,slug',
            'parent_id' => 'nullable|integer|exists:categories,id',
            'active'    => 'nullable|boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $validated['active'] = $request->boolean('active');

        Category::create($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Категория успешно создана.');
    }

    public function show(string $id): void
    {
        //
    }

    public function edit(Category $category): View
    {
        $categories = Category::where('id', '!=', $category->id)
            ->orderBy('title')
            ->get();

        return view('admin.categories.edit', compact('category', 'categories'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'title'     => 'required|string|max:255',
            'slug'      => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'parent_id' => 'nullable|integer|exists:categories,id|not_in:' . $category->id,
            'active'    => 'nullable|boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $validated['active'] = $request->boolean('active');

        $category->update($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Категория обновлена.');
    }

    public function destroy(string $id): void
    {
        //
    }
}
