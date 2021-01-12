<?php

namespace Database\Seeders;

use App\Repository\SettingRepository;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    private $settingRepository;

    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
          'task_order' => 'desc',
          'dashboard_color' => 'white',
          'show_number_of_tasks' => 6
        ];

        foreach ($settings as $key => $value) {
            if (!$this->settingRepository->existsByKey($key)) {
                $this->settingRepository->saveSetting([
                   'key' => $key,
                   'value' => $value
                ]);
            }
        }
    }
}
