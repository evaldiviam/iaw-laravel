<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; // 	Illuminate\Filesystem\Filesystem
use App\Models\Store;

class StoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Borramos lo que hay he importamos
        DB::table('stores')->delete();
        $json = File::get("database/data/stores.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            Store::create(array(
                'name' => $obj->name,
                'address' => $obj->address,
            ));
        }
    }
}
