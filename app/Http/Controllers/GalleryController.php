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

        Gallery::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return back();
    }

    public function update(Request $request, Gallery $gallery)
{
    if (Auth::user()->role !== 'admin') abort(403);

    $gallery->update([
        'name' => $request->name,
        'description' => $request->description
    ]);

    return back()->with('success', 'Gallery updated.');
}

    public function addImage(Request $request, Gallery $gallery)
    {
        if (Auth::user()->role !== 'admin') abort(403);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('galleries', 'public');

            GalleryImage::create([
                'gallery_id' => $gallery->id,
                'image' => $path
            ]);
        }

        return back();
    }

    public function deleteImage(GalleryImage $image)
    {
        if (Auth::user()->role !== 'admin') abort(403);

        Storage::disk('public')->delete($image->image);
        $image->delete();

        return back();
    }

    public function destroy(Gallery $gallery)
    {
        if (Auth::user()->role !== 'admin') abort(403);

        foreach ($gallery->images as $img) {
            Storage::disk('public')->delete($img->image);
        }

        $gallery->delete();

        return back();
    }
}