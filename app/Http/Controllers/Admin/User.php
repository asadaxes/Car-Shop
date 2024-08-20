<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Users;


class User extends Controller
{
    public function users_list(Request $request)
    {
        $query = Users::query();
        $searchTerm = $request->input('search');
        $query->when($searchTerm, function ($query) use ($searchTerm) {
            $query->where('full_name', 'like', '%' . $searchTerm . '%')
                ->orWhere('email', 'like', '%' . $searchTerm . '%')
                ->orWhere('phone', 'like', '%' . $searchTerm . '%')
                ->orWhere('whatsapp_no', 'like', '%' . $searchTerm . '%')
                ->orWhere('gender', 'like', '%' . $searchTerm . '%')
                ->orWhere('country', 'like', '%' . $searchTerm . '%')
                ->orWhere('city', 'like', '%' . $searchTerm . '%')
                ->orWhere('state', 'like', '%' . $searchTerm . '%')
                ->orWhere('zip_code', 'like', '%' . $searchTerm . '%');
                
        });
        $users = $query->paginate(30);
        $data = [
            'active_page' => 'users_list',
            'users' => $users
        ];
        return view('admin.users_list', $data);
    }

    public function users_add()
    {
        $data = [
            'active_page' => 'users_add'
        ];
        return view('admin.users_add', $data);
    }

    public function users_add_handler(Request $request)
    {
        $request->validate([
            'avatar' => 'image|mimes:jpeg,png,jpg',
            'full_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'whatsapp_no' => 'string|max:20',
            'address' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'birth_date' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'flag' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:20',
            'password' => 'nullable|string|min:6',
            'is_active' => 'required|boolean',
            'is_admin' => 'required|boolean',
        ], [
            'avatar.image' => 'The avatar must be an image file.',
            'avatar.mimes' => 'The avatar must be a file of type: jpeg, png, jpg.',
            'avatar.max' => 'The avatar may not be greater than 2MB in size.',
            'full_name.required' => 'The full name field is required.',
            'full_name.max' => 'The full name may not be greater than 100 characters.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'phone.required' => 'The phone field is required.',
            'whatsapp_no.required' => 'The whatsapp_no field is required.',
            'gender.required' => 'The gender field is required.',
            'birth_date.required' => 'The birth date field is required.',
            'address.required' => 'The address  field is required.',
            'address.max' => 'The address may not be greater than 255 characters.',
            'city.required' => 'The city field is required.',
            'city.max' => 'The city may not be greater than 255 characters.',
            'flag.required' => 'The flag field is required.',
            'flag.max' => 'The flag may not be greater than 255 characters.',
            'country.required' => 'The country field is required.',
            'country.max' => 'The country may not be greater than 255 characters.',
            'state.required' => 'The state field is required.',
            'state.max' => 'The state may not be greater than 255 characters.',
            'zip_code.required' => 'The zip code field is required.',
            'zip_code.max' => 'The zip code may not be greater than 20 characters.',
            'password.min' => 'The password must be at least 6 characters.',
            'is_active.required' => 'The account status field is required.',
            'is_active.boolean' => 'The account status must be either true or false.',
            'is_admin.required' => 'The admin access field is required.',
            'is_admin.boolean' => 'The admin access must be either true or false.',
        ]);

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('public/users');
        } else {
            $avatarPath = 'users/default_avatar.png';
        }

        $user = new Users();
        $user->full_name = $request->full_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->whatsapp_no = $request->whatsapp_no;
        $user->gender = $request->gender;
        $user->birth_date = $request->birth_date;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->flag = $request->flag;
        $user->country = $request->country;
        $user->state = $request->state;
        $user->zip_code = $request->zip_code;
        $user->is_active = $request->is_active;
        $user->is_admin = $request->is_admin;
        $user->avatar = $avatarPath;
        $user->password = Hash::make($request->password);
        $user->save();

        event(new Registered($user));
        return redirect()->route('admin_users_list')->with('success', 'User has been created successfully');
    }

    public function users_view()
    {
        try {
            $uid = request()->query('uid');
            $user = Users::findOrFail($uid);
            $data = [
                'active_page' => 'users_edit',
                'user' => $user
            ];
            return view('admin.users_view', $data);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin_users_list');
        }
    }

    public function users_view_handler(Request $request)
    {
        $request->validate([
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg', 
            'full_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,'.$request->user_id,
            'phone' => 'required|string|max:20',
            'whatsapp_no' => 'string|max:20',
            'address' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'birth_date' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'flag' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:20',
            'password' => 'nullable|string|min:6',
            'is_active' => 'required|boolean',
            'is_admin' => 'required|boolean',
        ], [
            'avatar.image' => 'The avatar must be an image file.',
            'avatar.mimes' => 'The avatar must be a file of type: jpeg, png, jpg.',
            'avatar.max' => 'The avatar may not be greater than 2MB in size.',
            'full_name.required' => 'The full name field is required.',
            'full_name.max' => 'The full name may not be greater than 100 characters.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'phone.required' => 'The phone field is required.',
            'whatsapp_no.required' => 'The whatsapp_no field is required.',
            'gender.required' => 'The gender field is required.',
            'birth_date.required' => 'The birth date field is required.',
            'address.required' => 'The address  field is required.',
            'address.max' => 'The address may not be greater than 255 characters.',
            'city.required' => 'The city field is required.',
            'city.max' => 'The city may not be greater than 255 characters.',
            'flag.required' => 'The flag field is required.',
            'flag.max' => 'The flag may not be greater than 255 characters.',
            'country.required' => 'The country field is required.',
            'country.max' => 'The country may not be greater than 255 characters.',
            'state.required' => 'The state field is required.',
            'state.max' => 'The state may not be greater than 255 characters.',
            'zip_code.required' => 'The zip code field is required.',
            'zip_code.max' => 'The zip code may not be greater than 20 characters.',
            'password.min' => 'The password must be at least 6 characters.',
            'is_active.required' => 'The account status field is required.',
            'is_active.boolean' => 'The account status must be either true or false.',
            'is_admin.required' => 'The admin access field is required.',
            'is_admin.boolean' => 'The admin access must be either true or false.',
        ]);

        $user = Users::findOrFail($request->user_id);
        $user->full_name = $request->full_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->whatsapp_no = $request->whatsapp_no;
        $user->gender = $request->gender;
        $user->birth_date = $request->birth_date;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->flag = $request->flag;
        $user->country = $request->country;
        $user->state = $request->state;
        $user->zip_code = $request->zip_code;
        $user->is_active = $request->is_active;
        $user->is_admin = $request->is_admin;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::exists($user->avatar)) {
                Storage::delete($user->avatar);
            }
            $avatarPath = $request->file('avatar')->store('public/users');
            $user->avatar = $avatarPath;
        }

        $user->save();

        return redirect()->route('admin_users_view', ['uid' => $user->id])->with('success', 'User details updated successfully.');
    }

    public function users_delete_account(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ], [
            'user_id.required' => 'User ID is required',
            'user_id.exists' => 'Invalid user ID'
        ]);
        $user = Users::findOrFail($request->user_id);
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot delete yourself');
        }
        $user->delete();
        return redirect()->back()->with('success', 'User account deleted successfully');
    }
}