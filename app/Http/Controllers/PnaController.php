<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;
use App\Library\SslCommerz\SslCommerzNotification;
use App\Models\PartAndAccessories;
use App\Models\Pna_Brands;
use App\Models\Pna_Category;
use App\Models\Pna_Reviews;
use App\Models\Pna_Orders;
use App\Models\Pna_Config;
use App\Models\Payments;
use App\Models\Invoices;


class PnaController extends Controller
{
    public function landing_page(Request $request)
    {
        $query = PartAndAccessories::query();
        $searchTerm = $request->input('search');
        $query->when($searchTerm, function ($query) use ($searchTerm) {
            $query->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('type', 'like', '%' . $searchTerm . '%')
                  ->orWhereJsonContains('tags', $searchTerm)
                  ->orWhereHas('brand', function ($q) use ($searchTerm) {
                      $q->where('name', 'like', '%' . $searchTerm . '%');
                  })
                  ->orWhereHas('category', function ($q) use ($searchTerm) {
                      $q->where('name', 'like', '%' . $searchTerm . '%');
                  });
        });
        $pna = $query->orderBy('id', 'desc')->paginate(30);

        $pna_brands = Pna_Brands::orderBy('id', 'desc')->limit(10)->get();
        $pna_categories = Pna_Category::orderBy('id', 'desc')->limit(10)->get();
        
        $data = [
            'active_page' => 'pna',
            'pnas' => $pna,
            'pna_brands' => $pna_brands,
            'pna_categories' => $pna_categories
        ];
        return view('pna.landing_page', $data);
    }    

    public function product_view($slug)
    {
        try {
            $product = PartAndAccessories::where('slug', $slug)->first();
            $reviews = Pna_Reviews::where('pna_id', $product->id)->orderBy('issued_at', 'desc')->paginate(10);
            $userReview = $product->user_reviews()->where('user_id', auth()->id())->first();
            $charges = Pna_Config::first();
            $data = [
                'active_page' => 'pna',
                'product' => $product,
                'reviews' => $reviews,
                'userReview' => $userReview,
                'charges' => $charges
            ];
            return view('pna.product_view', $data);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('pna_landing_page');
        }
    }

    public function product_review_handler(Request $request)
    {
        $validatedData = $request->validate([
            'pna_id' => 'required|integer|exists:part_and_accessories,id',
            'rating' => 'required|integer|between:1,5',
            'feedback' => 'required|string|max:255',
        ]);

        $review = new Pna_Reviews();
        $review->pna_id = $validatedData['pna_id'];
        $review->user_id = auth()->id();
        $review->rating = $validatedData['rating'];
        $review->feedback = $validatedData['feedback'];
        $review->save();

        return redirect()->back()->with('success', 'Review submitted successfully.');
    }

    public function cart()
    {
        $data = [
            'active_page' => 'pna'
        ];
        return view('pna.cart', $data);
    }

    public function checkout()
    {
        $charges = Pna_Config::first();
        $data = [
            'active_page' => 'pna',
            'charges' => $charges
        ];
        return view('pna.checkout', $data);
    }

    public function checkout_handler(Request $request)
    {
        $validatedData = $request->validate([
            'full_name' => 'required|string',
            'email' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'country' => 'required|string',
            'zip_code' => 'required|string',
            'delivery_method' => 'required|in:pay_with_ssl,cash_on_delivery',
            'products' => 'required'
        ], [
            'full_name.required' => 'Full name is required.',
            'email.required' => 'Email is required.',
            'phone.required' => 'Phone number is required.',
            'address.required' => 'Shipping address is required.',
            'city.required' => 'City is required.',
            'state.required' => 'State is required.',
            'country.required' => 'Country is required.',
            'zip_code.required' => 'Zip code is required.',
            'delivery_method.required' => 'The delivery method is required.',
            'delivery_method.in' => 'Invalid delivery method selected. Please choose either pay with ssl or cash on delivery.',
            'products.required' => 'Product data was missing! please try to remove and re-add the products into cart.'
        ]);

        $shipping_address = [
            "full_name" => $validatedData['full_name'],
            "email" => $validatedData['email'],
            "phone" => $validatedData['phone'],
            "address" => $validatedData['address'],
            "city" => $validatedData['city'],
            "country" => $validatedData['country'],
            "zip_code" => $validatedData['zip_code'],
            "state" => $validatedData['state']
        ];

        $products = json_decode($request->products, true);

        foreach ($products as $product) {
            $pna = PartAndAccessories::findOrFail($product['id']);
            if ($product['quantity'] > $pna->quantity) {
                return redirect()->route('pna_cart')->with('error', 'Insufficient stock for product: ' . $pna->title);
            }
        }

        $order_id = '#' . Str::upper(Str::random(12));

        $charge = Pna_Config::first();
        $delivery_charge = 0;
        if($validatedData['city'] === 'Dhaka'){
            $delivery_charge = $charge->delivery_charge_inside;
        }else{
            $delivery_charge = $charge->delivery_charge_outside;
        }
        $tax = $charge->tax;

        $total_amount = 0;
        foreach ($products as $product) {
            $total_amount += $product['price'] * $product['quantity'];
        }
        $total_amount += $delivery_charge + $tax;

        foreach ($products as $product) {
            $order = new Pna_Orders();
            $order->order_id = $order_id;
            $order->pna_id = $product['id'];
            $order->user_id = auth()->user()->id;
            $order->amount = $total_amount;
            $order->quantity = $product['quantity'];
            $order->delivery_method = $validatedData['delivery_method'];
            $order->shipping_address = json_encode($shipping_address);
            $order->save();
        }

        if($validatedData['delivery_method'] === 'pay_with_ssl'){
            $post_data = array();        
            $post_data['total_amount'] = $total_amount;
            $post_data['currency'] = "BDT";
            $post_data['tran_id'] = uniqid();

            $post_data['cus_name'] = $validatedData['full_name'];
            $post_data['cus_email'] = $validatedData['email'];
            $post_data['cus_add1'] = $validatedData['address'];
            $post_data['cus_phone'] = $validatedData['phone'];

            $post_data['ship_name'] = "No Shipping";
            $post_data['shipping_method'] = "NO";
            $post_data['product_name'] = "PnA";
            $post_data['product_category'] = "PnA";
            $post_data['product_profile'] = "non-physical-goods";

            $post_data['value_a'] = "ref001";
            $post_data['value_b'] = "ref002";
            $post_data['value_c'] = "ref003";
            $post_data['value_d'] = "ref004";

            Payments::create([
                'user_id' => auth()->user()->id,
                'pna_order_id' => $order_id,
                'amount' => $total_amount,
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
        }else if($validatedData['delivery_method'] === 'cash_on_delivery'){
            Pna_Orders::where('order_id', $order_id)->update(['status' => 'success']);
            $invoice = new Invoices();
            $invoice->customer_id = auth()->user()->id;
            $invoice->pna_id = $order_id;
            $invoice->save();
            foreach ($products as $product) {
                $pna = PartAndAccessories::findOrFail($product['id']);
                $pna->quantity = $pna->quantity - $product['quantity'];
                $pna->save();
            }
            session()->flash('payment_successful_clean_cart', true);
            return redirect()->route('user_my_orders')->with('success', 'Your order has been placed successfully. We are preparing your products & deliver it soon...');
        }
    }

    public function clear_payment_success_session()
    {
        session()->forget('payment_successful_clean_cart');
        return response()->json(['message' => 'Payment was successfull and order has placed.']);
    }
}