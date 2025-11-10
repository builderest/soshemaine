<?php

class SettingController
{
    private SettingModel $settings;

    public function __construct()
    {
        $this->settings = new SettingModel();
    }

    public function update(array $data): void
    {
        foreach ($data as $key => $value) {
            $this->settings->set($key, $value);
            $GLOBALS['settings'][$key] = $value;
        }
    }
}

