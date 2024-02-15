<?php

namespace Database\Seeders;

use App\Helpers\UserSSOHelper;
use App\Models\Jabatan;
use App\Models\UnitKerja;
use App\Models\Users;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // FIND USER GROUP WITH JABATAN STAFF AND UNIT KERJA DEVELOPER

        $data = new Users();
        $data->username = env('EMAIL_DEVELOPER', 'root@localhost.com');
        $data->password = Hash::make('root');
        $data->name = 'Administrator';
        $data->email = env('EMAIL_DEVELOPER', 'root@localhost.com');
        $data->id_user_group = 1;
        $data->status = 1;
        $data->created_by = 1;
        $data->save();

//        dummy user security
        $NPK = [1111, 2222, 3333, 4444];
        foreach ($NPK as $npk) {
            $data = new Users();
            $data->username = $npk.'@localhost.com';
            $data->password = Hash::make('root');
            $data->name = 'Sekuriti '.$npk;
            $data->email = $npk.'@localhost.com';
            $data->id_user_group = 4;
            $data->npk = $npk;
//      $data->area = 2;
            $data->id_company = 1;
            $data->status = 1;
            $data->created_by = 1;
            $data->save();
        }

    }
}
