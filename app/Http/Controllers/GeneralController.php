<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\SslCommerz\SslCommerzNotification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Brands;
use App\Models\Vehicles;
use App\Models\Campaigns;
use App\Models\Payments;
use App\Models\PartAndAccessories;
use App\Models\Pna_Orders;
use App\Models\Invoices;
use App\Models\Blogs;
use App\Models\Pages;

class GeneralController extends Controller
{
    public function success(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');
    
        $sslc = new SslCommerzNotification();
        $order_details = Payments::where('tran_id', $tran_id)->select('tran_id', 'status', 'currency', 'amount', 'vehicle_id', 'pna_order_id')->first();
            if ($order_details->status == 'Pending') {
                $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);
                if ($order_details->vehicle_id) {
                    if ($validation) {
                        if (Auth::check()) {
                            $userId = Auth::id();
                            $lastAddedVehicle = Vehicles::where('dealer_id', $userId)
                                ->where('status', 'temp')
                                ->latest('publish_date')
                                ->first();
                            if ($lastAddedVehicle) {
                                $lastAddedVehicle->update(['status' => 'active']);
                            }
                        }
                        Payments::where('tran_id', $tran_id)->update(['status' => 'Complete']);
                        return redirect()->route('user_my_vehicles')->with('success', 'Your car has been published successfully.');
                    }
                } else if ($order_details->pna_order_id) {
                    Payments::where('tran_id', $tran_id)->update(['status' => 'Complete']);
                    Pna_Orders::where('order_id', $order_details->pna_order_id)->update(['status' => 'success']);
                    $invoice = new Invoices();
                    $invoice->customer_id = Auth::id();
                    $invoice->pna_id = $order_details->pna_order_id;
                    $invoice->save();
                    $pnaOrders = Pna_Orders::where('order_id', $order_details->pna_order_id)->get();
                    foreach ($pnaOrders as $pnaOrder) {
                        $pna = PartAndAccessories::findOrFail($pnaOrder->pna_id);
                        $pna->quantity = $pna->quantity - $pnaOrder->quantity;
                        $pna->save();
                    }
                    session()->flash('payment_successful_clean_cart', true);
                    return redirect()->route('user_my_orders')->with('success', 'Your order has been placed successfully. We are preparing your products & deliver it soon...');
                }
            } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
                if ($order_details->vehicle_id) {
                    return redirect()->route('user_my_vehicles')->with('success', 'Your car is already published.');
                } elseif ($order_details->pna_order_id) {
                    Payments::where('tran_id', $tran_id)->update(['status' => 'Complete']);
                    Pna_Orders::where('order_id', $order_details->pna_order_id)->update(['status' => 'success']);
                    $invoice = new Invoices();
                    $invoice->customer_id = Auth::id();
                    $invoice->pna_id = $order_details->pna_order_id;
                    $invoice->save();
                    $pnaOrders = Pna_Orders::where('order_id', $order_details->pna_order_id)->get();
                    foreach ($pnaOrders as $pnaOrder) {
                        $pna = PartAndAccessories::findOrFail($pnaOrder->pna_id);
                        $pna->quantity = $pna->quantity - $pnaOrder->quantity;
                        $pna->save();
                    }
                    session()->flash('payment_successful_clean_cart', true);
                    return redirect()->route('user_my_orders')->with('success', 'Your order is already placed.');
                }
            } else {
                if ($order_details->vehicle_id) {
                    Payments::where('tran_id', $tran_id)->update(['status' => 'Failed']);
                    return redirect()->route('vehicle_publish_new')->with('error', 'Invalid Transaction.');
                } elseif ($order_details->pna_order_id) {
                    Pna_Orders::where('order_id', $order_details->pna_order_id)->update(['status' => 'failed']);
                    return redirect()->route('pna_checkout')->with('error', 'Invalid Transaction.');
                }
            }
    }

    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $order_details = Payments::where('tran_id', $tran_id)->select('tran_id', 'status', 'vehicle_id', 'pna_order_id')->first();
    
        if ($order_details->status == 'Pending') {
            Payments::where('tran_id', $tran_id)->update(['status' => 'Failed']);
            if ($order_details->vehicle_id) {
                return redirect()->route('vehicle_publish_new')->with('error', 'Transaction has failed.');
            } elseif ($order_details->pna_order_id) {
                Pna_Orders::where('order_id', $order_details->pna_order_id)->update(['status' => 'failed']);
                return redirect()->route('pna_checkout')->with('error', 'Transaction has failed.');
            }
        } elseif ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
            if ($order_details->vehicle_id) {
                return redirect()->route('user_my_vehicles')->with('success', 'Transaction is already successful.');
            } elseif ($order_details->pna_order_id) {
                return redirect()->route('user_my_orders')->with('success', 'Transaction is already successful.');
            }
        } else {
            if ($order_details->vehicle_id) {
                return redirect()->route('vehicle_publish_new')->with('error', 'Transaction is invalid.');
            } elseif ($order_details->pna_order_id) {
                return redirect()->route('pna_checkout')->with('error', 'Transaction is invalid.');
            }
        }
    }    

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $order_details = Payments::where('tran_id', $tran_id)->select('tran_id', 'status', 'vehicle_id', 'pna_order_id')->first();
    
        if ($order_details->status == 'Pending') {
            Payments::where('tran_id', $tran_id)->update(['status' => 'Canceled']);
            if ($order_details->vehicle_id) {
                return redirect()->route('vehicle_publish_new')->with('error', 'Transaction is canceled.');
            } elseif ($order_details->pna_order_id) {
                Pna_Orders::where('order_id', $order_details->pna_order_id)->update(['status' => 'canceled']);
                return redirect()->route('pna_checkout')->with('error', 'Transaction is canceled.');
            }
        } elseif ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
            if ($order_details->vehicle_id) {
                return redirect()->route('user_my_vehicles')->with('success', 'Transaction is already successful.');
            } elseif ($order_details->pna_order_id) {
                return redirect()->route('user_my_orders')->with('success', 'Transaction is already successful.');
            }
        } else {
            if ($order_details->vehicle_id) {
                return redirect()->route('vehicle_publish_new')->with('error', 'Transaction is invalid.');
            } elseif ($order_details->pna_order_id) {
                return redirect()->route('pna_checkout')->with('error', 'Transaction is invalid.');
            }
        }
    }    

    public function ipn(Request $request)
    {
        if ($request->input('tran_id')) {
            $tran_id = $request->input('tran_id');
            $order_details = Payments::where('tran_id', $tran_id)->select('tran_id', 'status', 'vehicle_id', 'pna_order_id')->first();

            if ($order_details->status == 'Pending') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($request->all(), $tran_id, $request->input('amount'), $request->input('currency'));

                if ($validation) {
                    Payments::where('tran_id', $tran_id)->update(['status' => 'Processing']);
                    if ($order_details->vehicle_id) {
                        return redirect()->route('user_my_vehicles')->with('success', 'Transaction is successfully completed.');
                    } elseif ($order_details->pna_order_id) {
                        Pna_Orders::where('order_id', $order_details->pna_order_id)->update(['status' => 'success']);
                        session()->flash('payment_successful_clean_cart', true);
                        return redirect()->route('user_my_orders')->with('success', 'Transaction is successfully completed.');
                    }
                }
            } elseif ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
                if ($order_details->vehicle_id) {
                    return redirect()->route('user_my_vehicles')->with('success', 'Transaction is already successful.');
                } elseif ($order_details->pna_order_id) {
                    return redirect()->route('user_my_orders')->with('success', 'Transaction is already successful.');
                }
            } else {
                if ($order_details->vehicle_id) {
                    return redirect()->route('vehicle_publish_new')->with('error', 'Transaction is invalid.');
                } elseif ($order_details->pna_order_id) {
                    return redirect()->route('pna_checkout')->with('error', 'Transaction is invalid.');
                }
            }
        } else {
            return redirect()->route('vehicle_publish_new')->with('error', 'Invalid data.');
        }
    }


    public function home()
    {
        $new_cars = Vehicles::where('condition', 'new')->whereIn('status', ['active', 'sold'])->limit(15)->get();
        $used_cars = Vehicles::where('condition', 'used')->whereIn('status', ['active', 'sold'])->limit(15)->get();
        $reconditioned_cars = Vehicles::where('condition', 'recondition')->whereIn('status', ['active', 'sold'])->limit(15)->get();
        $brands_data = Brands::with(['vehicles' => function ($query) {
            $query->whereIn('status', ['active', 'sold']);
        }])->whereHas('vehicles', function ($query) {
            $query->whereIn('status', ['active', 'sold']);
        })->get();
        $blogs = Blogs::orderBy('publish_date', 'desc')->limit(10)->get();

        $brandModels = [];
        foreach ($brands_data as $brand) {
            $models = [];
            foreach ($brand->vehicles as $vehicle) {
                $models[] = $vehicle->model;
            }
            $brandModels[$brand->name] = $models;
        }
        $data = [
            'new_cars' => $new_cars,
            'used_cars' => $used_cars,
            'reconditioned_cars' => $reconditioned_cars,
            'brands_data' => $brandModels,
            'blogs' => $blogs
        ];
        return view('general.home', $data);
    }

    public function select_item_for_sell()
    {
        return view('general.select_item_for_sell');   
    }

    public function vehicle_details($car)
    {
        $car = Vehicles::where('slug', $car)->first();
        if (!$car || !in_array($car->status, ['active', 'sold'])) {
            return redirect('/');
        }
        
        $recent_cars = Vehicles::whereIn('status', ['active', 'sold'])->orderBy('id', 'desc')->limit(15)->get();

        $data = [
            'car' => $car,
            'recent_cars' => $recent_cars
        ];
        return view('general.vehicle_details', $data);
    }

    public function vehicle_publish_new()
    {
        $data = [
            'campaigns' => Campaigns::all()
        ];
        return view('general.vehicle_publish_new', $data);
    }

    public function vehicle_publish_new_handler(Request $request)
    {
        $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:vehicles_categories,id',
            'condition' => 'required|in:new,used,recondition,modified',
            'model' => 'required',
            'price' => 'required',
            'description' => 'required',
            'features' => 'required',
            'features_options' => 'required',
            'mileage' => 'required',
            'fuel_type' => 'required',
            'engine' => 'required',
            'drivetrain' => 'required',
            'exterior_color' => 'required',
            'interior_color' => 'required',
            'model_year' => 'required',
            'registration_year' => 'nullable',
            'images' => 'required|string',
            'campaign' => 'required',
        ], [
            'brand_id.required' => 'Brand id is required.',
            'brand_id.exists' => 'Invalid brand id.',
            'category_id.required' => 'Category id is required.',
            'category_id.exists' => 'Invalid category id.',
            'condition.required' => 'The condition is required.',
            'model.required' => 'The vehicle model is required.',
            'price.required' => 'The price is required.',
            'description.required' => 'The description is required.',
            'features.required' => 'The features is required.',
            'features_options.required' => 'The extra features is required.',
            'mileage.required' => 'The mileage is required.',
            'fuel_type.required' => 'The fuel type is required.',
            'engine.required' => 'The engine is required.',
            'drivetrain.required' => 'The drivetrain is required.',
            'exterior_color.required' => 'The exterior color is required.',
            'interior_color.required' => 'The interior color is required.',
            'model_year.required' => 'The model year is required.',
            'images.required' => 'Select at least one image.',
            'campaign.required' => 'Select at least one campaign package.',
        ]);

        $images = [];
        $imageDataArray = json_decode($request->input('images'), true);
        foreach ($imageDataArray as $key => $imageData) {
            $extension = explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
            $imageName = time() . $key . Str::random(10) . '.' . $extension;
            Storage::disk('public')->put('vehicles/' . $imageName, base64_decode(preg_replace('/^data:image\/(png|jpeg|jpg);base64,/', '', $imageData)));
            $images[] = 'vehicles/' . $imageName;
        }

        $vehicle = new Vehicles();
        $vehicle->dealer_id = auth()->user()->id;
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
        $vehicle->images = json_encode($images);
        $vehicle->campaign = $request->input('campaign');
        $vehicle->setAttribute('features', $request->input('features'));
        $vehicle->setAttribute('details', $request->input('features_options'));
        $vehicle->save();

        
        $campaign = $request->input('campaign');
        $campaignArray = json_decode($campaign, true);
        $lastValue = end($campaignArray);
        $amount = end($lastValue);

        $post_data = array();        
        $post_data['total_amount'] = $amount;
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid();

        // Customer Information
        $post_data['cus_name'] = auth()->user()->full_name ?? 'not provided';
        $post_data['cus_email'] = auth()->user()->email ?? 'not provided';
        $post_data['cus_add1'] = auth()->user()->address ?? 'not provided';
        $post_data['cus_phone'] = auth()->user()->phone ?? 'not provided';

        // Shipping Information
        $post_data['ship_name'] = "No Shipping";
        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Vehicle Ad";
        $post_data['product_category'] = "Ad";
        $post_data['product_profile'] = "non-physical-goods";

        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        // Store order data in the database with pending status
        Payments::create([
            'user_id' => auth()->user()->id,
            'vehicle_id' => $vehicle->id,
            'amount' => $amount,
            'currency' => $post_data['currency'],
            'tran_id' => $post_data['tran_id'],
            'status' => 'Pending',
        ]);

        $sslc = new SslCommerzNotification();
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
    }

    public function vehicle_model_search(Request $request)
    {
        $brand_name = $request->input('brand');
        $model = $request->input('model');
        $condition = $request->input('condition');
        $priceRange = $request->input('price');

        $brand = Brands::where('name', $brand_name)->first();

        if (!$brand) {
            return redirect()->back();   
        }
        $priceRangeArray = explode('-', $priceRange);
        $minPrice = $priceRangeArray[0];
        $maxPrice = $priceRangeArray[1];

        $query = Vehicles::query();
        $query->where('brand_id', $brand->id)
            ->where('model', 'like', '%' . $model . '%')
            ->where('condition', $condition)
            ->whereBetween('price', [$minPrice, $maxPrice]);
    
        $results = $query->paginate(20);

        $brands_data = Brands::with(['vehicles' => function ($query) {
            $query->whereIn('status', ['active', 'sold']);
        }])->whereHas('vehicles', function ($query) {
            $query->whereIn('status', ['active', 'sold']);
        })->get();   
        $brandModels = [];
        foreach ($brands_data as $brand) {
            $models = [];
            foreach ($brand->vehicles as $vehicle) {
                $models[] = $vehicle->model;
            }
            $brandModels[$brand->name] = $models;
        }

        $data = [
            'results' => $results,
            'brands_data' => $brandModels
        ];
        return view('general.vehicle_model_search', $data);
    }

    public function search_query(Request $request)
    {
        $query = Vehicles::query();
        $searchTerm = $request->input('search');
        if ($searchTerm) {
            $query->where(function ($query) use ($searchTerm) {
                $query->where('model', 'like', '%' . $searchTerm . '%')
                      ->orWhere('mileage', 'like', '%' . $searchTerm . '%')
                      ->orWhere('fuel_type', 'like', '%' . $searchTerm . '%')
                      ->orWhere('condition', 'like', '%' . $searchTerm . '%')
                      ->orWhere('exterior_color', 'like', '%' . $searchTerm . '%')
                      ->orWhere('interior_color', 'like', '%' . $searchTerm . '%')
                      ->orWhere('model_year', 'like', '%' . $searchTerm . '%')
                      ->orWhereHas('brand', function ($query) use ($searchTerm) {
                          $query->where('name', 'like', '%' . $searchTerm . '%');
                      })
                      ->orWhereHas('category', function ($query) use ($searchTerm) {
                          $query->where('title', 'like', '%' . $searchTerm . '%');
                      });
            });
        }
        $query->whereIn('status', ['active', 'sold'])
              ->orderByRaw("CASE WHEN campaign LIKE '%\"Urgent\"%' THEN 1 ELSE 2 END")
              ->orderBy('id', 'desc');
        $results = $query->paginate(20);
        $data = ['results' => $results];
        return view('general.vehicle_search_query', $data);
    }

    public function blogs()
    {
        $posts = Blogs::orderBy('publish_date', 'desc')->paginate(20);
        $data = [
            'posts' => $posts
        ];
        return view('general.blogs', $data);
    }

    public function blogs_details($article)
    {
        $post = Blogs::where('slug', $article)->first();
        $recent_posts = Blogs::orderBy('publish_date', 'desc')->limit(10)->get();
        $data = [
            'post' => $post,
            'recent_posts' => $recent_posts
        ];
        return view('general.blogs_details', $data);
    }

    public function page_details($slug)
    {
        $page = Pages::where('slug', $slug)->first();
        $data = [
            'page' => $page
        ];
        return view('general.page', $data);
    }
}