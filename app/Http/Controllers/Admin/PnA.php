<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\PartAndAccessories;
use App\Models\Pna_Brands;
use App\Models\Pna_Category;
use App\Models\Pna_Orders;
use App\Models\Pna_Reviews;
use App\Models\Pna_Config;


class PnA extends Controller
{
    public function brands(Request $request)
    {
        $query = Pna_Brands::query();
        $searchTerm = $request->input('search');
        $query->when($searchTerm, function ($query) use ($searchTerm) {
            $query->where('name', 'like', '%' . $searchTerm . '%');
        });
        $brands = $query->orderBy('id', 'desc')->paginate(20);
        $data = [
            'active_page' => 'pna_brands',
            'brands_data' => $brands
        ];
        return view('admin.pna_brands', $data);
    }

    public function brands_add(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);
        $brand = new Pna_Brands();
        $brand->name = $request->input('name');
        $brand->save();
        return redirect()->back()->with('success', 'Brand added successfully');
    }

    public function brands_remove(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        $brand = Pna_Brands::findOrFail($request->input('id'));
        $brand->delete();
        return redirect()->back()->with('success', 'Brand deleted successfully');
    }

    public function categories(Request $request)
    {
        $query = Pna_Category::query();
        $searchTerm = $request->input('search');
        $query->when($searchTerm, function ($query) use ($searchTerm) {
            $query->where('name', 'like', '%' . $searchTerm . '%');
        });
        $categories = $query->orderBy('id', 'desc')->paginate(20);
        $data = [
            'active_page' => 'pna_categories',
            'categories' => $categories
        ];
        return view('admin.pna_categories', $data);
    }

    public function categories_add(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);
        $category = new Pna_Category();
        $category->name = $request->input('name');
        $category->save();
        return redirect()->back()->with('success', 'Category added successfully');
    }

    public function categories_remove(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        $category = Pna_Category::findOrFail($request->input('id'));
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully');
    }

    public function inventory(Request $request)
    {
        $query = PartAndAccessories::query();
        $searchTerm = $request->input('search');
        $query->when($searchTerm, function ($query) use ($searchTerm) {
            $query->where('title', 'like', '%' . $searchTerm . '%');
        });
        $products = $query->orderBy('id', 'desc')->paginate(20);
        $data = [
            'active_page' => 'pna_inventory',
            'products' => $products
        ];
        return view('admin.pna_inventory_list', $data);
    }

    public function inventory_add()
    {
        $brands = Pna_Brands::all();
        $categories = Pna_Category::all();
        $data = [
            'active_page' => 'pna_inventory',
            'pna_brands' => $brands,
            'categories' => $categories
        ];
        return view('admin.pna_inventory_add', $data);
    }

    public function inventory_add_handler(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'tags' => 'required|string',
            'type' => 'required|in:Parts,Accessories',
            'brand_id' => 'required|exists:pna__brands,id',
            'category_id' => 'required|exists:pna__categories,id',
            'quantity' => 'required|integer|min:1',
            'regular_price' => 'nullable|integer|min:1',
            'sale_price' => 'required|integer|min:1',
            'meta_title' => 'required|string',
            'meta_description' => 'required|string',
            'images' => 'required|string'
        ], [
            'title.required' => 'The title field is required.',
            'tags.required' => 'Put at least one tag.',
            'type.required' => 'Please select a type (Parts or Accessories).',
            'type.in' => 'The selected type is invalid. Must be either Parts or Accessories.',
            'brand_id.required' => 'Please select a brand.',
            'brand_id.exists' => 'The selected brand does not exist.',
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'The selected category does not exist.',
            'quantity.required' => 'The quantity field is required.',
            'quantity.integer' => 'The quantity must be an integer.',
            'quantity.min' => 'The quantity must be at least :min.',
            'regular_price.integer' => 'The regular price must be an integer.',
            'regular_price.min' => 'The regular price must be at least :min.',
            'sale_price.required' => 'The sale price field is required.',
            'sale_price.integer' => 'The sale price must be an integer.',
            'sale_price.min' => 'The sale price must be at least :min.',
            'meta_title.required' => 'The meta title field is required.',
            'meta_description.required' => 'The meta description field is required.',
            'images.required' => 'Select at least one image.',
        ]);

        $images = [];
        $imageDataArray = json_decode($request->input('images'), true);
        foreach ($imageDataArray as $key => $imageData) {
            $extension = explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
            $imageName = time() . $key . Str::random(10) . '.' . $extension;
            Storage::disk('public')->put('pna/' . $imageName, base64_decode(preg_replace('/^data:image\/(png|jpeg|jpg);base64,/', '', $imageData)));
            $images[] = 'pna/' . $imageName;
        }

        $pna = new PartAndAccessories();
        $pna->title = $request->title;
        $pna->description = $request->description;
        $pna->tags = json_encode(array_map('trim', explode(',', $request->tags)));;
        $pna->type = $request->type;
        $pna->brand_id = $request->brand_id;
        $pna->category_id = $request->category_id;
        $pna->quantity = $request->quantity;
        $pna->regular_price = $request->regular_price;
        $pna->sale_price = $request->sale_price;
        $pna->has_warranty = $request->has('has_warranty');
        $pna->meta_title = $request->meta_title;
        $pna->meta_description = $request->meta_description;
        $pna->images = json_encode($images);
        $pna->save();

        return redirect()->route('admin_pna_inventory')->with('success', 'Product has been published successfully.');
    }

    public function inventory_edit()
    {
        try {
            $id = request()->query('id');
            $product = PartAndAccessories::findOrFail($id);
            $brands = Pna_Brands::all();
            $categories = Pna_Category::all();
            $data = [
                'active_page' => 'pna_inventory',
                'product' => $product,
                'pna_brands' => $brands,
                'categories' => $categories
            ];
            return view('admin.pna_inventory_edit', $data);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin_pna_inventory');
        }
    }

    public function inventory_edit_handler(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:part_and_accessories,id',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'tags' => 'required|string',
            'type' => 'required|in:Parts,Accessories',
            'brand_id' => 'required|exists:pna__brands,id',
            'category_id' => 'required|exists:pna__categories,id',
            'quantity' => 'required|integer|min:1',
            'regular_price' => 'nullable|integer|min:1',
            'sale_price' => 'required|integer|min:1',
            'meta_title' => 'required|string',
            'meta_description' => 'required|string',
            'images' => 'required|string'
        ], [
            'id.required' => 'PnA id is required.',
            'id.exists' => 'Invalid PnA id.',
            'title.required' => 'The title field is required.',
            'tags.required' => 'Put at least one tag.',
            'type.required' => 'Please select a type (Parts or Accessories).',
            'type.in' => 'The selected type is invalid. Must be either Parts or Accessories.',
            'brand_id.required' => 'Please select a brand.',
            'brand_id.exists' => 'The selected brand does not exist.',
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'The selected category does not exist.',
            'quantity.required' => 'The quantity field is required.',
            'quantity.integer' => 'The quantity must be an integer.',
            'quantity.min' => 'The quantity must be at least :min.',
            'regular_price.integer' => 'The regular price must be an integer.',
            'regular_price.min' => 'The regular price must be at least :min.',
            'sale_price.required' => 'The sale price field is required.',
            'sale_price.integer' => 'The sale price must be an integer.',
            'sale_price.min' => 'The sale price must be at least :min.',
            'meta_title.required' => 'The meta title field is required.',
            'meta_description.required' => 'The meta description field is required.',
            'images.required' => 'Select at least one image.',
        ]);

        $pna = PartAndAccessories::findOrFail($request->id);
        $pna->title = $request->title;
        $pna->description = $request->description;
        $pna->tags = json_encode(array_map('trim', explode(',', $request->tags)));;
        $pna->type = $request->type;
        $pna->brand_id = $request->brand_id;
        $pna->category_id = $request->category_id;
        $pna->quantity = $request->quantity;
        $pna->regular_price = $request->regular_price;
        $pna->sale_price = $request->sale_price;
        $pna->has_warranty = $request->has('has_warranty');
        $pna->meta_title = $request->meta_title;
        $pna->meta_description = $request->meta_description;

        $images = [];
        $imageDataArray = json_decode($request->input('images'), true);
        foreach ($imageDataArray as $imageData) {
            if (strpos($imageData, 'data:image') === 0) {
                $extension = explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
                $imageName = time() . Str::random(10) . '.' . $extension;
                Storage::disk('public')->put('pna/' . $imageName, base64_decode(preg_replace('/^data:image\/(png|jpeg|jpg);base64,/', '', $imageData)));
                $images[] = 'pna/' . $imageName;
            } else {
                $images[] = $imageData;
            }
        }
        $pna->images = json_encode($images);
        $pna->save();
        return redirect()->route('admin_pna_inventory_edit', ['id' => $pna->id])->with('success', 'Product details updated successfully.');
    }

    public function inventory_remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:part_and_accessories,id'
        ], [
            'id.required' => 'PnA id is required.',
            'id.exists' => 'Invalid PnA id.',
        ]);
        $product = PartAndAccessories::findOrFail($request->input('product_id'));
        $product->delete();
        return redirect()->back()->with('success', 'Product deleted successfully.');
    }

    public function reviews()
    {
        $reviews = Pna_Reviews::orderBy('id', 'desc')->paginate(20);
        $data = [
            'active_page' => 'pna_reviews',
            'reviews' => $reviews
        ];
        return view('admin.pna_reviews', $data);
    }

    public function reviews_remover(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:pna__reviews,id',
        ]);
        $review = Pna_Reviews::findOrFail($request->id);
        $review->delete();

        return redirect()->back()->with('success', 'Review deleted successfully.');
    }

    public function orders(Request $request)
    {
        $query = Pna_Orders::query();
        $searchTerm = $request->input('search');
        $query->when($searchTerm, function ($query) use ($searchTerm) {
            $query->where('order_id', 'like', '%' . $searchTerm . '%')
                ->orWhere('amount', 'like', '%' . $searchTerm . '%')
                ->orWhere('deliver_status', 'like', '%' . $searchTerm . '%')
                ->orWhereHas('user', function ($q) use ($searchTerm) {
                    $q->where('full_name', 'like', '%' . $searchTerm . '%');
                });
        });
        $orders = $query->where('status', 'success')
                        ->orderByRaw("CASE deliver_status
                                    WHEN 'preparing' THEN 1
                                    WHEN 'on_the_way' THEN 2
                                    WHEN 'delivered' THEN 3
                                    ELSE 4
                                    END")
                        ->orderBy('issued_at', 'desc')
                        ->paginate(10);
        $config = Pna_Config::first();
        $data = [
            'active_page' => 'pna_orders',
            'orders' => $orders,
            'config' => $config
        ];
        return view('admin.pna_orders', $data);
    }

    public function orders_status_updater(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            'deliver_status' => 'required|in:preparing,on_the_way,delivered'
        ], [
            'order_id.required' => 'Order ID is required',
            'deliver_status.required' => 'Status is required',
            'deliver_status.in' => 'Invalid status provided'
        ]);
        $updated = Pna_Orders::where('order_id', $request->order_id)->update(['deliver_status' => $request->deliver_status]);
        if ($updated) {
            return redirect()->back()->with('success', 'Status updated successfully.');
        } else {
            return redirect()->back()->with('error', 'No orders found to update.');
        }
    }

    public function config()
    {
        $config = Pna_Config::first();
        $data = [
            'active_page' => 'pna_config',
            'config' => $config
        ];
        return view('admin.pna_config', $data);
    }

    public function config_updater(Request $request)
    {
        $config = Pna_Config::first();
        $config->delivery_charge_inside = $request->input('delivery_charge_inside');
        $config->delivery_charge_outside = $request->input('delivery_charge_outside');
        $config->tax = $request->input('tax');
        $config->save();
        return redirect()->back()->with('success', 'Save changes successfully.');
    }
}