<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Campaigns;

class CampaignsSeeder extends Seeder
{
    public function run()
    {
        Campaigns::create([
            'name' => 'Regular',
            'pricing' => '[{"3":"99"},{"5":"199"},{"7":"299"},{"10":"399"},{"15":"499"},{"30":"999"}]',
        ]);
        Campaigns::create([
            'name' => 'Urgent',
            'pricing' => '[{"2":"199"},{"4":"299"},{"7":"399"},{"10":"499"},{"15":"599"},{"20":"799"},{"25":"899"},{"30":"1100"}]',
        ]);
    }
}