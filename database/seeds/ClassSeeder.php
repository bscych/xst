<?php

use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        foreach (App\Model\Classmodel::all() as $clas) {
          
                if ($clas->which_day_1 === null) {
                    $clas->which_day_1 = [];
                    $clas->save();
                }
                if ($clas->which_day_1 === []) {
                    
                }
                $days = collect();
                foreach (json_decode($clas->which_day_1) as $day) {
                    $dayArr = ['day' => $day, 'time' => ['start_at' => null, 'end_at' => null]];
                    $days->push($dayArr);
                }
                $clas->which_day_1 = $days->toJson();
                $clas->save();
           
        }
    }

}
