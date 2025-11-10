<?php

class Theme
{
    private const DEFAULT_THEME = 'dark';

    public static function getDefault(): string
    {
        $settingModel = new SettingModel();
        return $settingModel->get('theme_default') ?: self::DEFAULT_THEME;
    }

    public static function available(): array
    {
        return ['light', 'dark', 'brand-ocean', 'brand-violet'];
    }
}

