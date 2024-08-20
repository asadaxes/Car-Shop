<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Users;
use App\Models\Vehicles;
use App\Models\PartAndAccessories;
use App\Models\Payments;
use App\Models\Blogs;
use App\Models\Brands;
use App\Models\Pages;
use App\Models\Settings;

class Generals extends Controller
{
    public function dashboard()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $payments_vehicles = Payments::whereNotNull('vehicle_id')->whereMonth('issued_at', $currentMonth)->whereYear('issued_at', $currentYear)->get();
        $payments_pna = Payments::whereNotNull('pna_order_id')->whereMonth('issued_at', $currentMonth)->whereYear('issued_at', $currentYear)->get();
        $data = [
            'active_page' => 'dashboard',
            'total_users' => Users::count(),
            'total_vehicles' => Vehicles::count(),
            'total_payments' => Payments::count(),
            'payments_vehicles' => $payments_vehicles,
            'payments_pna' => $payments_pna,
            'total_blogs' => Blogs::count(),
            'total_pna' => PartAndAccessories::count(),
            'total_brands' => Brands::count(),
            'total_new_vehicles' => Vehicles::where('condition', 'new')->count(),
            'total_used_vehicles' => Vehicles::where('condition', 'used')->count(),
            'total_recondition_vehicles' => Vehicles::where('condition', 'recondition')->count(),
            'total_modified_vehicles' => Vehicles::where('condition', 'modified')->count(),
            'recent_payments' => Payments::orderBy('issued_at', 'desc')->limit(10)->get(),
            'total_payments' => Payments::sum('amount')
        ];
        return view('admin.dashboard', $data);
    }

    public function pages(Request $request)
    {
        $query = Pages::query();
        $searchTerm = $request->input('search');
        $query->when($searchTerm, function ($query) use ($searchTerm) {
            $query->where('name', 'like', '%' . $searchTerm . '%');
        });
        $pages = $query->orderBy('id', 'desc')->paginate(10);
        $data = [
            'active_page' => 'pages',
            'pages' => $pages
        ];
        return view('admin.pages', $data);
    }

    public function pages_add(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'position' => 'required|string|in:left,right'
        ], [
            'name.required' => 'The title is required.',
            'name.string' => 'The title must be a string.',
            'name.max' => 'The title may not be greater than 255 characters.',
            'content.required' => 'The content is required.',
            'content.string' => 'The content must be a string.',
            'position.required' => 'The position field is required.',
            'position.string' => 'The position must be a string.',
            'position.in' => 'The position must be either "left" or "right".'
        ]);
        $page = new Pages();
        $page->name = $validatedData['name'];
        $page->content = $validatedData['content'];
        $page->position = $validatedData['position'];
        $page->save();
        return redirect()->back()->with('success', 'Page added successfully.');
    }

    public function pages_edit(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|exists:pages,id',
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'position' => 'required|string|in:left,right'
        ], [
            'id.exists' => 'The selected page does not exist.',
            'name.required' => 'The title is required.',
            'name.string' => 'The title must be a string.',
            'name.max' => 'The title may not be greater than 255 characters.',
            'content.required' => 'The content is required.',
            'content.string' => 'The content must be a string.',
            'position.required' => 'The position field is required.',
            'position.string' => 'The position must be a string.',
            'position.in' => 'The position must be either "left" or "right".'
        ]);
        $page = Pages::findOrFail($validatedData['id']);
        $page->name = $validatedData['name'];
        $page->content = $validatedData['content'];
        $page->position = $validatedData['position'];
        $page->save();
        return redirect()->back()->with('success', 'Page updated successfully.');
    }

    public function pages_delete(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|exists:pages,id'
        ], [
            'id.exists' => 'The selected page does not exist.'
        ]);
        $page = Pages::findOrFail($validatedData['id']);
        $page->delete();
        return redirect()->back()->with('success', 'Page deleted successfully.');
    }

    public function settings()
    {
        $data = [
            'active_page' => 'settings'
        ];
        return view('admin.settings', $data);
    }

    public function settings_updater(Request $request)
    {
        $validatedData = $request->validate([
            'title_site' => 'required|string|max:255',
            'title_admin' => 'required|string|max:255',
            'footer_copyright' => 'nullable|string',
            'footer_description' => 'nullable|string',
            'footer_link_1' => 'nullable|string|max:255',
            'footer_link_2' => 'nullable|string|max:255',
            'footer_link_3' => 'nullable|string|max:255',
            'contact_address' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'contact_email' => 'nullable|email|max:255',
            'ga_id' => 'nullable|string|max:50',
            'meta_author' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'social_ids' => 'required|string',
        ], [
            'title_site.required' => 'Site title is required.',
            'title_site.string' => 'Site title must be a string.',
            'title_site.max' => 'Site title may not be greater than 255 characters.',
            'title_admin.required' => 'Admin title is required.',
            'title_admin.string' => 'Admin title must be a string.',
            'title_admin.max' => 'Admin title may not be greater than 255 characters.',
            'footer_link_1.max' => 'Footer link 1 may not be greater than 255 characters.',
            'footer_link_2.max' => 'Footer link 2 may not be greater than 255 characters.',
            'footer_link_3.max' => 'Footer link 3 may not be greater than 255 characters.',
            'contact_address.max' => 'Contact address may not be greater than 255 characters.',
            'contact_phone.max' => 'Contact phone may not be greater than 20 characters.',
            'contact_email.email' => 'Contact email must be a valid email address.',
            'contact_email.max' => 'Contact email may not be greater than 255 characters.',
            'ga_id.max' => 'Google Analytics ID may not be greater than 50 characters.',
            'meta_author.max' => 'Meta author may not be greater than 255 characters.',
            'social_ids.required' => 'At least add a social link.'
        ]);

        if ($request->hasFile('favicon')) {
            $logoPath = $request->file('favicon')->store('public/settings');
            $validatedData['favicon'] = $logoPath;
        }
        if ($request->hasFile('logo_site')) {
            $logoPath = $request->file('logo_site')->store('public/settings');
            $validatedData['logo_site'] = $logoPath;
        }
        if ($request->hasFile('logo_admin')) {
            $logoPath = $request->file('logo_admin')->store('public/settings');
            $validatedData['logo_admin'] = $logoPath;
        }

        $settings = Settings::first();
        $settings->update($validatedData);
        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}