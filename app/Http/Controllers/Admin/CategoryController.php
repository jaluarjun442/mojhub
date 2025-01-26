<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Category::query();

            if ($request->parent_category_id) {
                $query->where('parent_category_id', $request->parent_category_id);
            }

            return DataTables::of($query)
                ->addColumn('parent_category', function ($category) {
                    return $category->parent_category_id ? $category->parent_category->title : '-';
                })
                ->addColumn('image', function ($category) {
                    return $category->image
                        ? asset('public/uploads/category/' . $category->image) // Generates a web URL
                        : null;
                })
                ->addColumn('actions', function ($category) {
                    return view('admin.categories.partials.actions', compact('category'))->render();
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        $parentCategories = Category::whereNull('parent_category_id')->get();
        return view('admin.categories.index', compact('parentCategories'));
    }
    public function create()
    {
        $categories = Category::whereNull('parent_category_id')->get();
        return view('admin.categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:category,slug',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'parent_category_id' => 'nullable|exists:category,id',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->only(['title', 'slug', 'platform', 'parent_category_id', 'status']);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageExtension = $image->getClientOriginalExtension();
            $imageName = time() . '.webp';
            $imageResource = null;
            if ($imageExtension === 'jpeg' || $imageExtension === 'jpg') {
                $imageResource = imagecreatefromjpeg($image);
            } elseif ($imageExtension === 'png') {
                $imageResource = imagecreatefrompng($image);
            }
            if ($imageResource) {
                $imagePath = public_path('uploads/category/' . $imageName);
                imagewebp($imageResource, $imagePath, 95);
                imagedestroy($imageResource);
                $data['image'] = $imageName;
            } else {
                $originalImageName = time() . '.' . $imageExtension;
                $image->move(public_path('uploads/category'), $originalImageName);
                $data['image'] = $originalImageName;
            }
        }
        Category::create($data);
        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }


    public function edit(Category $category)
    {
        $categories = Category::whereNull('parent_category_id')->get();
        return view('admin.categories.edit', compact('category', 'categories'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => ['required', Rule::unique('category')->ignore($category->id)],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'parent_category_id' => 'nullable|exists:category,id',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->only(['title', 'slug', 'platform', 'parent_category_id', 'status']);

        if ($request->hasFile('image')) {
            if ($category->image && file_exists(public_path('uploads/category/' . $category->image))) {
                unlink(public_path('uploads/category/' . $category->image)); // Remove the old image
            }
            $image = $request->file('image');
            $imageExtension = $image->getClientOriginalExtension();
            $imageName = time() . '.webp';
            $imageResource = null;
            if ($imageExtension === 'jpeg' || $imageExtension === 'jpg') {
                $imageResource = imagecreatefromjpeg($image);
            } elseif ($imageExtension === 'png') {
                $imageResource = imagecreatefrompng($image);
            }
            if ($imageResource) {
                $imagePath = public_path('uploads/category/' . $imageName);
                imagewebp($imageResource, $imagePath, 95);
                imagedestroy($imageResource);
                $data['image'] = $imageName;
            } else {
                $originalImageName = time() . '.' . $imageExtension;
                $image->move(public_path('uploads/category'), $originalImageName);
                $data['image'] = $originalImageName;
            }
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        if ($category->image && file_exists(public_path($category->image))) {
            unlink(public_path($category->image)); // Remove the image
        }
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}
