<?php
// app/Http/Controllers/Admin/ContactController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::latest();
        
        // Filter berdasarkan status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }
        
        // Filter berdasarkan tanggal
        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $contacts = $query->paginate(20);
        
        $unreadCount = Contact::unread()->count();
        $readCount = Contact::read()->count();
        $repliedCount = Contact::replied()->count();
        $totalCount = Contact::count();
        
        return view('admin.contacts.index', compact(
            'contacts', 
            'unreadCount',
            'readCount',
            'repliedCount',
            'totalCount'
        ));
    }
    
    public function show(Contact $contact)
    {
        // Mark as read when viewing
        if ($contact->status == 'unread') {
            $contact->update(['status' => 'read']);
        }
        
        return view('admin.contacts.show', compact('contact'));
    }
    
    public function updateStatus(Contact $contact, Request $request)
    {
        $request->validate([
            'status' => 'required|in:unread,read,replied',
            'admin_notes' => 'nullable|string'
        ]);
        
        $contact->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes
        ]);
        
        return redirect()->back()->with('success', 'Status berhasil diperbarui');
    }
    
    public function destroy(Contact $contact)
    {
        $contact->delete();
        
        return redirect()->route('admin.contacts.index')
            ->with('success', 'Pesan berhasil dihapus');
    }
    
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:mark_read,mark_replied,delete',
            'contacts' => 'required|array'
        ]);
        
        switch ($request->action) {
            case 'mark_read':
                Contact::whereIn('id', $request->contacts)->update(['status' => 'read']);
                $message = 'Pesan berhasil ditandai sebagai sudah dibaca';
                break;
                
            case 'mark_replied':
                Contact::whereIn('id', $request->contacts)->update(['status' => 'replied']);
                $message = 'Pesan berhasil ditandai sebagai sudah dibalas';
                break;
                
            case 'delete':
                Contact::whereIn('id', $request->contacts)->delete();
                $message = 'Pesan berhasil dihapus';
                break;
        }
        
        return redirect()->back()->with('success', $message);
    }
}