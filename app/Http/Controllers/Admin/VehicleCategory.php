<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VehiclesCategory;


class VehicleCategory extends Controller
{
    public function vehicle_category(Request $request)
    {
        $query = VehiclesCategory::query();
        $searchTerm = $request->input('search');
        $query->when($searchTerm, function ($query) use ($searchTerm) {
            $query->where('title', 'like', '%' . $searchTerm . '%');
        });
        $categories = $query->paginate(20);
        $data = [
            'active_page' => 'vehicle_category',
            'categories' => $categories
        ];
        return view('admin.vehicle_category', $data);
    }

    public function vehicle_category_add(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
        ]);
        $category = new VehiclesCategory();
        $category->title = $request->input('title');
        $category->save();
        return redirect()->back()->with('success', 'Category added successfully');
    }

    public function vehicle_category_edit(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'title' => 'required|string',
        ]);
        $category =VehiclesCategory::findOrFail($request->input('id'));
        $category->title = $request->input('title');
        $category->save();
        return redirect()->back()->with('success', 'Category added successfully');
    }

    public function vehicle_category_delete(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        $category = VehiclesCategory::findOrFail($request->input('id'));
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully');
    }
}