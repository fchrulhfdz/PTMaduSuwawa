<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    /**
     * Tampilkan daftar testimonial.
     */
    public function index()
    {
        $testimonials = Testimonial::orderByDesc('created_at')->paginate(10);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    /**
     * Tampilkan form untuk membuat testimonial baru.
     */
    public function create()
    {
        return view('admin.testimonials.create');
    }

    /**
     * Simpan testimonial baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_title' => 'nullable|string|max:255',
            'rating'         => 'required|integer|min:1|max:5',
            'testimonial'    => 'required|string|min:10',
            'is_active'      => 'nullable|boolean',
            'is_featured'    => 'nullable|boolean',
        ]);

        // Default value jika tidak dikirim (checkbox unchecked)
        $validated['is_active']   = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');

        Testimonial::create($validated);

        return redirect()
            ->route('admin.testimonials.index')
            ->with('success', 'Testimonial berhasil ditambahkan!');
    }

    /**
     * Tampilkan form untuk edit testimonial.
     */
    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    /**
     * Update data testimonial.
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_title' => 'nullable|string|max:255',
            'rating'         => 'required|integer|min:1|max:5',
            'testimonial'    => 'required|string|min:10',
            'is_active'      => 'nullable|boolean',
            'is_featured'    => 'nullable|boolean',
        ]);

        $validated['is_active']   = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');

        $testimonial->update($validated);

        return redirect()
            ->route('admin.testimonials.index')
            ->with('success', 'Testimonial berhasil diperbarui!');
    }

    /**
     * Hapus testimonial.
     */
    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return redirect()
            ->route('admin.testimonials.index')
            ->with('success', 'Testimonial berhasil dihapus!');
    }

    /**
     * Toggle status aktif (via AJAX).
     */
    public function toggleStatus(Testimonial $testimonial)
    {
        $testimonial->update([
            'is_active' => !$testimonial->is_active,
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Toggle status featured (via AJAX).
     */
    public function toggleFeatured(Testimonial $testimonial)
    {
        $testimonial->update([
            'is_featured' => !$testimonial->is_featured,
        ]);

        return response()->json(['success' => true]);
    }
}