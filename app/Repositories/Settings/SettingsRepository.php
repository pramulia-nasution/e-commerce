<?php

namespace App\Repositories\Settings;

interface SettingsRepository{
    public function getThumbnailSize();
    public function getMediumSize();
    public function getLargeSize();
    public function setSizeImages($request);
}

