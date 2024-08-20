<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Brands;


class Brand extends Controller
{
    public function brands(Request $request)
    {
        $query = Brands::query();
        $searchTerm = $request->input('search');
        $query->when($searchTerm, function ($query) use ($searchTerm) {
            $query->where('name', 'like', '%' . $searchTerm . '%');
        });
        $brands = $query->orderBy('id', 'desc')->paginate(40);
        $data = [
            'active_page' => 'brands',
            'brands_data' => $brands
        ];
        return view('admin.brands', $data);
    }

    public function brands_add(Request $request)
    {
        $request->validate([
            'logo' => 'required|image',
            'name' => 'required|string',
        ]);
        $brand = new Brands();
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $name = strtolower($request->input('name'));
            $name = str_replace(' ', '_', $name);
            $extension = $file->getClientOriginalExtension();
            $fileName = $name.'_'.time().'.'.$extension;
            $filePath = $file->storeAs('brands', $fileName, 'public');
            $brand->logo = $filePath;
        }
        $brand->name = $request->input('name');
        $brand->save();
        return redirect()->route('admin_brands')->with('success', 'Brand added successfully');
    }

    public function brands_remove(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        $brand = Brands::findOrFail($request->input('id'));
        if ($brand->logo) {
            Storage::disk('public')->delete($brand->logo);
        }
        $brand->delete();
        return redirect()->route('admin_brands')->with('success', 'Brand deleted successfully');
    }
}