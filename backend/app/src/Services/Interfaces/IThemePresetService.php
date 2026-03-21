<?php

namespace App\Services\Interfaces;

use App\Models\ThemePreset;

interface IThemePresetService
{
    public function getAll(): array;
    public function getById(int $themePresetID): ?ThemePreset;
    public function create(ThemePreset $themePreset): ThemePreset;
    public function update(ThemePreset $themePreset): bool;
    public function delete(int $themePresetID): bool;
}
