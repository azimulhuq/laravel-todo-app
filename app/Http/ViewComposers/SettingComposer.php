<?php
namespace App\Http\ViewComposers;

use App\Utility\SettingSingletone;
use Illuminate\View\View;

class SettingComposer {
    public function compose(View $view)
    {
        $settings = SettingSingletone::get();
        $view->with('settings', $settings);
    }
}
