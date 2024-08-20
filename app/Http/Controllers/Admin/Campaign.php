<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campaigns;


class Campaign extends Controller
{
    public function campaigns(Request $request)
    {
        $campaigns = Campaigns::all();
        $data = [
            'active_page' => 'campaigns',
            'campaigns' => $campaigns
        ];
        return view('admin.campaigns', $data);
    }

    public function campaigns_edit(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:campaigns,id',
            'name' => 'required|string',
            'pricing' => 'required|string',
            'pricing.*.duration' => 'required|numeric',
            'pricing.*.cost' => 'required|numeric'
        ], [
            'id.required' => 'Campaign ID is required',
            'id.exists' => 'Invalid campaign ID',
            'name.required' => 'The name field is required.',
            'name.string' => 'The name field must be a string.',
            'pricing.required' => 'The pricing field is required.',
            'pricing.*.duration.required' => 'The duration field for each pricing must be provided.',
            'pricing.*.duration.numeric' => 'The duration field for each pricing must be a number.',
            'pricing.*.cost.required' => 'The cost field for each pricing must be provided.',
            'pricing.*.cost.numeric' => 'The cost field for each pricing must be a number.'
        ]);        
        $campaign = Campaigns::findOrFail($request->id);
        $campaign->name = $request->input('name');
        $campaign->pricing = $request->input('pricing');
        $campaign->save();
        return redirect()->back()->with('success', 'Campaign updated successfully');
    }
}