<?php
namespace Database\Seeders;
use App\Models\UserGroup;
use Illuminate\Database\Seeder;


class UserGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id_user_group' => 1,
                'name' => 'ADMINISTRATOR'
            ],
            [
                'id_user_group' => 2,
                'name' => 'ADMIN HOLDING'
            ],
            [
                'id_user_group' => 3,
                'name' => 'ADMIN COMPANY'
            ],
            [
                'id_user_group' => 4,
                'name' => 'SECURITY'
            ],
            [
                'id_user_group' => 5,
                'name' => 'PIC/GA'
            ],
        ];

        // GET ID JABATAN AND ID UNIT KERJA BASE ON NAME
        foreach ($data as $key => $dt) {
            // DO SAVE USER GROUP
            $UG = new UserGroup();
            $UG->sort = $key + 1;
            $UG->name = $dt['name'];
            $UG->status = 1;
            $UG->created_by = 1;

            $UG->save();
        }

    }
}
