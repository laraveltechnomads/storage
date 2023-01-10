<?php

namespace Database\Seeders;

use App\Models\Admin\PatientCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PatientCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'couple',
            'partner',
            'baby',
            'donor',
            'individual',
            'anc',
            'surrogate'
        ];
        
        foreach($data as $insert) {
            $in['reg_code'] = $insert;
            $in['description'] = Str::title($insert);
            $in['status'] = 1;
            PatientCategory::updateOrCreate( ['description' =>  $in['description']],$in);
            PatientCategory::where('description', 'partner')->update(['status' => 0]);
        }
    }
}
