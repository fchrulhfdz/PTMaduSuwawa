<?php

namespace App\Http\Controllers\Admin;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testimonials = Testimonial::latest()->paginate(10);
        
        return view('admin.testimonials.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.testimonials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_title' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'testimonial' => 'required|string|min:10',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        Testimonial::create($validated);

        return redirect()->route('admin.testimonials.index')
                        ->with('success', 'Testimonial berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_title' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'testimonial' => 'required|string|min:10',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $testimonial->update($validated);

        return redirect()->route('admin.testimonials.index')
                        ->with('success', 'Testimonial berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')
                        ->with('success', 'Testimonial berhasil dihapus!');
    }

    /**
     * Toggle status aktif testimonial
     */
    public function toggleStatus(Testimonial $testimonial)
    {
        $testimonial->update([
            'is_active' => !$testimonial->is_active
        ]);

        return response()->json([
            'success' => true,
            'new_status' => $testimonial->is_active,
            'message' => 'Status testimonial berhasil diubah'
        ]);
    }

    /**
     * Toggle status featured testimonial
     */
    public function toggleFeatured(Testimonial $testimonial)
    {
        $testimonial->update([
            'is_featured' => !$testimonial->is_featured
        ]);

        return response()->json([
            'success' => true,
            'new_featured' => $testimonial->is_featured,
            'message' => 'Status featured testimonial berhasil diubah'
        ]);
    }
}