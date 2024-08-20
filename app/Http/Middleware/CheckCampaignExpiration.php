<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Vehicles;

class CheckCampaignExpiration
{
    public function handle(Request $request, Closure $next)
    {
        $vehicles = Vehicles::all();

        foreach ($vehicles as $vehicle) {
            $campaign = json_decode($vehicle->campaign, true);
            $publishDate = Carbon::parse($vehicle->publish_date);

            $packageDuration = 0;
            if (isset($campaign['Urgent'])) {
                $packageDuration = (int) array_keys($campaign['Urgent'])[0];
            } elseif (isset($campaign['Regular'])) {
                $packageDuration = (int) array_keys($campaign['Regular'])[0];
            }

            $expirationDate = $publishDate->copy()->addDays($packageDuration);
            
            if (Carbon::now()->greaterThan($expirationDate)) {
                $vehicle->status = 'closed';
                $vehicle->save();
            }
        }

        return $next($request);
    }
}