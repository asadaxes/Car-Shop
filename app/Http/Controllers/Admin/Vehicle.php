<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Vehicles;


class Vehicle extends Controller
{
    public function vehicles_list(Request $request)
    {
        $query = Vehicles::query();
        $searchTerm = $request->input('search');
        $query->where('status', '!=', 'temp')
            ->when($searchTerm, function ($query) use ($searchTerm) {
            $query->where('model', 'like', '%' . $searchTerm . '%')
                ->orWhere('price', 'like', '%' . $searchTerm . '%')
                ->orWhere('mileage', 'like', '%' . $searchTerm . '%')
                ->orWhere('fuel_type', 'like', '%' . $searchTerm . '%')
                ->orWhere('condition', 'like', '%' . $searchTerm . '%')
                ->orWhere('exterior_color', 'like', '%' . $searchTerm . '%')
                ->orWhere('interior_color', 'like', '%' . $searchTerm . '%')
                ->orWhere('model_year', 'like', '%' . $searchTerm . '%')
                ->orWhere('status', 'like', '%' . $searchTerm . '%')
                ->orWhereHas('brand', function ($query) use ($searchTerm) {
                    $query->where('name', 'like', '%' . $searchTerm . '%');
                })
                ->orWhereHas('category', function ($query) use ($searchTerm) {
                    $query->where('title', 'like', '%' . $searchTerm . '%');
                });
        });
        $vehicles = $query->orderBy('id', 'desc')->paginate(30);
        $data = [
            'active_page' => 'vehicles_list',
            'vehicles' => $vehicles
        ];
        return view('admin.vehicles_list', $data);
    }

    public function vehicles_view()
    {
        try {
            $id = request()->query('id');
            $vehicle = Vehicles::findOrFail($id);
            $data = [
                'active_page' => 'vehicles_edit',
                'vehicle' => $vehicle
            ];
            return view('admin.vehicles_view', $data);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin_vehicles_list');
        }
    }

    public function vehicles_view_handler(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:vehicles,id',
            'dealer_id' => 'required|exists:users,id',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:vehicles_categories,id',
            'condition' => 'required|in:new,used,recondition,modified',
            'model' => 'required',
            'price' => 'required',
            'description' => 'required',
            'mileage' => 'required',
            'fuel_type' => 'required',
            'engine' => 'required',
            'drivetrain' => 'required',
            'exterior_color' => 'required',
            'interior_color' => 'required',
            'model_year' => 'required',
            'registration_year' => 'nullable',
            'status' => 'required|in:active,closed,sold',
            'images' => 'required|string',
        ], [
            'id.required' => 'Vehicle id is required.',
            'id.exists' => 'Invalid vehicle id.',
            'brand_id.required' => 'Brand id is required.',
            'brand_id.exists' => 'Invalid brand id.',
            'dealer_id.required' => 'Dealer id is required.',
            'dealer_id.exists' => 'Invalid dealer id.',
            'category_id.required' => 'Category id is required.',
            'category_id.exists' => 'Invalid category id.',
            'condition.required' => 'The condition is required.',
            'condition.in' => 'Invalid condition provided.',
            'model.required' => 'The vehicle model is required.',
            'price.required' => 'The price is required.',
            'description.required' => 'The description is required.',
            'mileage.required' => 'The mileage is required.',
            'fuel_type.required' => 'The fuel type is required.',
            'engine.required' => 'The engine is required.',
            'drivetrain.required' => 'The drivetrain is required.',
            'exterior_color.required' => 'The exterior color is required.',
            'interior_color.required' => 'The interior color is required.',
            'model_year.required' => 'The model year is required.',
            'status.required' => 'Status is required.',
            'status.in' => 'Invalid status provided.',
            'images.required' => 'Select at least one image.',
        ]);

        $vehicle = Vehicles::findOrFail($request->id);
        $vehicle->dealer_id = $request->dealer_id;
        $vehicle->brand_id = $request->brand_id;
        $vehicle->category_id = $request->category_id;
        $vehicle->condition = $request->condition;
        $vehicle->model = $request->model;
        $vehicle->price = $request->price;
        $vehicle->description = $request->description;
        $vehicle->mileage = $request->mileage;
        $vehicle->fuel_type = $request->fuel_type;
        $vehicle->engine = $request->engine;
        $vehicle->drivetrain = $request->drivetrain;
        $vehicle->exterior_color = $request->exterior_color;
        $vehicle->interior_color = $request->interior_color;
        $vehicle->model_year = $request->model_year;
        $vehicle->registration_year = $request->registration_year;
        $vehicle->status = $request->status;
        $vehicle->images = $request->images;
        $vehicle->setAttribute('features', $request->input('features'));
        $vehicle->setAttribute('details', $request->input('features_options'));

        $images = [];
        $imageDataArray = json_decode($request->input('images'), true);
        foreach ($imageDataArray as $imageData) {
            if (strpos($imageData, 'data:image') === 0) {
                $extension = explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
                $imageName = time() . Str::random(10) . '.' . $extension;
                Storage::disk('public')->put('vehicles/' . $imageName, base64_decode(preg_replace('/^data:image\/(png|jpeg|jpg);base64,/', '', $imageData)));
                $images[] = 'vehicles/' . $imageName;
            } else {
                $images[] = $imageData;
            }
        }
        $vehicle->images = json_encode($images);
        $vehicle->save();

        return redirect()->route('admin_vehicles_view', ['id' => $vehicle->id])->with('success', 'Vehicle details updated successfully.');
    }

    public function vehicles_delete(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id'
        ], [
            'vehicle_id.required' => 'Vehicle ID is required',
            'vehicle_id.exists' => 'Invalid vehicle ID'
        ]);
        $vehicle = Vehicles::findOrFail($request->vehicle_id);
        $vehicle->delete();
        return redirect()->back()->with('success', 'Vehicle deleted successfully');
    }

    public function vehicles_status_updater(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:vehicles,id',
            'status' => 'required|in:active,closed,sold'
        ], [
            'id.required' => 'Vehicle ID is required',
            'id.exists' => 'Invalid vehicle ID',
            'status.required' => 'Status is required',
            'status.in' => 'Invalid status provided'
        ]);
        $vehicle = Vehicles::findOrFail($request->id);
        $vehicle->status = $request->status;
        $vehicle->save();
        return redirect()->back()->with('success', 'Status updated successfully.');
    }
}