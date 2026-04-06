<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') abort(403);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Gallery::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return back()->with('success', 'Gallery created.');
    }

    public function update(Request $request, Gallery $gallery)
    {
        if (Auth::user()->role !== 'admin') abort(403);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $gallery->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return back()->with('success', 'Gallery updated.');
    }

    public function addImage(Request $request, Gallery $gallery)
    {
        if (Auth::user()->role !== 'admin') abort(403);

        $request->validate([
            'images.*' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $path = $imageFile->store('galleries', 'public');

                GalleryImage::create([
                    'gallery_id' => $gallery->id,
                    'image' => $path,
                ]);
            }
        }

        return back()->with('success', 'Images uploaded successfully.');
    }

    public function deleteImage(GalleryImage $image)
    {
        if (Auth::user()->role !== 'admin') abort(403);

        if ($image->image && Storage::disk('public')->exists($image->image)) {
            Storage::disk('public')->delete($image->image);
        }

        $image->delete();

        return back()->with('success', 'Image deleted.');
    }

    public function destroy(Gallery $gallery)
    {
        if (Auth::user()->role !== 'admin') abort(403);

        foreach ($gallery->images as $img) {
            if ($img->image && Storage::disk('public')->exists($img->image)) {
                Storage::disk('public')->delete($img->image);
            }
        }

        $gallery->delete();

        return back()->with('success', 'Gallery deleted.');
    }
}