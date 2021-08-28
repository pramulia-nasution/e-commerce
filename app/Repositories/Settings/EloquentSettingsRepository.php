<?php

namespace App\Repositories\Settings;

use App\Model\Setting;

class EloquentSettingsRepository implements SettingsRepository{

    private $setting;

    function  __construct(Setting $setting){
        $this->setting = $setting;
    }

    public function getThumbnailSize(){
        $height = $this->setting->where('name','thumb_height')->first();
        $width = $this->setting->where('name','thumb_width')->first();
        return [$height->value,$width->value];
    }

    public function getMediumSize(){
        $height = $this->setting->where('name','medium_height')->first();
        $width = $this->setting->where('name','medium_width')->first();
        return [$height->value,$width->value];
    }

    public function getLargeSize(){
        $height = $this->setting->where('name','large_height')->first();
        $width = $this->setting->where('name','large_width')->first();
        return [$height->value,$width->value];
    }

    public function setSizeImages($request){
        $this->setting->where('name', 'thumb_height')
            ->update(['value' => $request->thumb_height]);
        $this->setting->where('name', 'thumb_width')
            ->update(['value' => $request->thumb_width]);
        $this->setting->where('name', 'medium_height')
            ->update(['value' => $request->medium_height]);
        $this->setting->where('name', 'medium_width')
            ->update(['value' => $request->medium_width]);
        $this->setting->where('name', 'large_height')
            ->update(['value' => $request->large_height]);
        $this->setting->where('name', 'large_width')
            ->update(['value' => $request->large_width]);
    return;
    }
}