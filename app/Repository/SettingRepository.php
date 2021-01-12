<?php
namespace App\Repository;
use App\Models\Setting;
use App\Traits\AuthTrait;

class SettingRepository {
    use AuthTrait;

    public function __construct()
    {

    }

    public function getAll()
    {
        return Setting::all();
    }

    /**
     * @param $key
     * @return bool
     */
    public function existsByKey($key)
    {
        $setting = Setting::where('key', $key)->first();
        return $setting ? true : false;
    }

    public function saveSetting($setting)
    {
        return Setting::firstOrCreate($setting);
    }
}
