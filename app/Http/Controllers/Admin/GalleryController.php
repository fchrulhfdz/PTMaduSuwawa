<?php
// app/Http/Controllers/Admin/GalleryController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $photos = Gallery::where('type', 'photo')
                        ->orderBy('order')
                        ->orderBy('created_at', 'desc')
                        ->get();
        
        $videos = Gallery::where('type', 'video')
                        ->orderBy('order')
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('admin.gallery.index', compact('photos', 'videos'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:photo,video',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,mp4,avi,mov|max:10240', // 10MB max
            'order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        $filePath = null;
        $thumbnailPath = null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            
            if ($request->type === 'photo') {
                $filePath = $file->store('gallery/photos', 'public');
            } else {
                $filePath = $file->store('gallery/videos', 'public');
                
                // Generate thumbnail untuk video (membutuhkan FFmpeg)
                // $thumbnailPath = $this->generateVideoThumbnail($file, $filePath);
            }
        }

        Gallery::create([
            'type' => $request->type,
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
            'thumbnail_path' => $thumbnailPath,
            'order' => $request->order ?? 0,
            'is_active' => $request->is_active ?? true
        ]);

        return redirect()->route('admin.gallery.index')
                        ->with('success', 'Item gallery berhasil ditambahkan');
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'type' => 'required|in:photo,video',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,avi,mov|max:10240',
            'order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        $filePath = $gallery->file_path;
        $thumbnailPath = $gallery->thumbnail_path;

        if ($request->hasFile('file')) {
            // Hapus file lama
            if ($gallery->file_path && Storage::exists($gallery->file_path)) {
                Storage::delete($gallery->file_path);
            }
            if ($gallery->thumbnail_path && Storage::exists($gallery->thumbnail_path)) {
                Storage::delete($gallery->thumbnail_path);
            }

            $file = $request->file('file');
            
            if ($request->type === 'photo') {
                $filePath = $file->store('gallery/photos', 'public');
            } else {
                $filePath = $file->store('gallery/videos', 'public');
                // $thumbnailPath = $this->generateVideoThumbnail($file, $filePath);
            }
        }

        $gallery->update([
            'type' => $request->type,
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
            'thumbnail_path' => $thumbnailPath,
            'order' => $request->order ?? 0,
            'is_active' => $request->is_active ?? true
        ]);

        return redirect()->route('admin.gallery.index')
                        ->with('success', 'Item gallery berhasil diperbarui');
    }

    public function destroy(Gallery $gallery)
    {
        $gallery->delete();

        return redirect()->route('admin.gallery.index')
                        ->with('success', 'Item gallery berhasil dihapus');
    }

    public function updateOrder(Request $request)
    {
        foreach ($request->order as $index => $id) {
            Gallery::where('id', $id)->update(['order' => $index]);
        }

        return response()->json(['success' => true]);
    }

    // Method untuk generate video thumbnail (opsional)
    private function generateVideoThumbnail($videoFile, $videoPath)
    {
        // Implementasi FFmpeg untuk generate thumbnail
        // Ini adalah contoh sederhana, Anda perlu menyesuaikan dengan environment
        try {
            $thumbnailName = pathinfo($videoPath, PATHINFO_FILENAME) . '_thumb.jpg';
            $thumbnailPath = 'gallery/thumbnails/' . $thumbnailName;
            
            // FFmpeg command untuk generate thumbnail
            $command = "ffmpeg -i " . $videoFile->getPathname() . " -ss 00:00:01 -vframes 1 " . storage_path('app/public/' . $thumbnailPath);
            exec($command);
            
            return $thumbnailPath;
        } catch (\Exception $e) {
            return null;
        }
    }
}