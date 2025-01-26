<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class WebsiteController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Website::query();

            return DataTables::of($query)
                ->addColumn('actions', function ($website) {
                    return view('admin.website.partials.actions', compact('website'))->render();
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('admin.website.index');
    }
    public function create()
    {
        return view('admin.website.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->only(['title', 'slug', 'status', 'sidebar', 'header_script', 'header_style', 'footer_script']);

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
                $imagePath = public_path('uploads/website/' . $imageName);
                imagewebp($imageResource, $imagePath, 95);
                imagedestroy($imageResource);
                $data['logo'] = $imageName;
            } else {
                $originalImageName = time() . '.' . $imageExtension;
                $image->move(public_path('uploads/website'), $originalImageName);
                $data['logo'] = $originalImageName;
            }
        }
        Website::create($data);
        return redirect()->route('admin.website.index')->with('success', 'Website created successfully.');
    }

    public function edit(Website $website)
    {
        return view('admin.website.edit', compact('website'));
    }

    public function update(Request $request, Website $website)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => ['required', Rule::unique('website')->ignore($website->id)],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->only(['title', 'slug', 'status', 'sidebar', 'header_script', 'header_style', 'footer_script']);

        if ($request->hasFile('image')) {
            if ($website->logo && file_exists(public_path('uploads/website/' . $website->logo))) {
                unlink(public_path('uploads/website/' . $website->logo)); // Remove the old image
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
                $imagePath = public_path('uploads/website/' . $imageName);
                imagewebp($imageResource, $imagePath, 95);
                imagedestroy($imageResource);
                $data['image'] = $imageName;
            } else {
                $originalImageName = time() . '.' . $imageExtension;
                $image->move(public_path('uploads/website'), $originalImageName);
                $data['image'] = $originalImageName;
            }
        }

        $website->update($data);

        return redirect()->route('admin.website.index')->with('success', 'Website updated successfully.');
    }

    public function destroy(Website $website)
    {
        if ($website->logo && file_exists(public_path($website->logo))) {
            unlink(public_path($website->logo)); // Remove the image
        }
        $website->delete();
        return redirect()->route('admin.website.index')->with('success', 'Website deleted successfully.');
    }
}
