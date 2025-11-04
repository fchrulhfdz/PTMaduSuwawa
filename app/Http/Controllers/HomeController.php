<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        $products = Product::where('stock', '>', 0)->take(6)->get();
        $testimonials = Testimonial::active()->featured()->take(3)->get();
        return view('home', compact('settings', 'products', 'testimonials'));
    }

    public function products()
    {
        $settings = Setting::all()->pluck('value', 'key');
        $products = Product::where('stock', '>', 0)->get();
        
        return view('products', compact('settings', 'products'));
    }

    public function about()
    {
        $settings = Setting::all()->pluck('value', 'key');
        
        return view('about', compact('settings'));
    }

    public function contact()
    {
        $settings = Setting::all()->pluck('value', 'key');
        
        return view('contact', compact('settings'));
    }

    // Tambahkan method testimonial
    public function testimonial()
    {
        $settings = Setting::all()->pluck('value', 'key');
        $testimonials = Testimonial::active()->latest()->get();
        $products = Product::where('stock', '>', 0)->get(); 
        return view('testimonial', compact('settings', 'testimonials', 'products'));
    }
}