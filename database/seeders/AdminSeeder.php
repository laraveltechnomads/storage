<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin\Administrator;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $permissions = DB::table('permissions')->select('name')->get();
        // $fetch = [];
        // foreach($permissions as $permission){
        //     $fetch[] = $permission->name;
        // }
        // Administrator::where('id',1)->update(['permission'=>json_encode($fetch,true)]);
        // $i= Administrator::where('id', 1)->first();
        // if($i)
        // {
        //     $i->permission = '["Dashboard_list", "Client_list", "Plans_list", "Subscriptions_list","Patient_category_list", "Subadmin_list", "Permission_list", "Role_list" ]';
        //     $i->save();
        // }


// DB::statement("INSERT INTO `slot_schedules` (`id`, `code`, `description`, `start_time`, `end_time`, `status`, `created_at`, `updated_at` ) VALUES
// (1, '1','Morning','05:00', '11:59', 0, '2022-04-09 00:00:47', '2022-04-09 01:57:15'),
// (2, '1','Afternoon','12:00', '04:59', 0, '2022-04-09 00:00:47', '2022-04-09 01:57:15'),
// (3, '1','Evening','05:00', '06:59', 0, '2022-04-09 00:00:47', '2022-04-09 01:57:15'),
// (4, '1','Day','00:00', '23:59', 1, '2022-04-09 00:00:47', '2022-04-09 01:57:15')");

// DB::statement("INSERT INTO `issue_types` (`id`, `description`, `status`, `unit_id`, `client_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
        // (1, 'Against Indent', 1, 1, 1, '2022-05-12 06:21:08', '2022-05-12 06:21:08', NULL),
        // (2, 'Against PR', 1, 1, 1, '2022-05-12 06:23:42', '2022-05-12 06:23:42', NULL),
        // (3, 'Direct', 1, 1, 1, '2022-05-12 06:23:54', '2022-05-12 06:23:54', NULL);");

        
    }
}


