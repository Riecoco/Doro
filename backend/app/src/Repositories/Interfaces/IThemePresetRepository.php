<?php

namespace App\Repositories\Interfaces;

use App\Models\ThemePreset;

interface IThemePresetRepository
{
    public function getAll(): array;
    public function getById(int $themePresetID): ?ThemePreset;
    public function create(ThemePreset $themePreset, int $userID): int;
    public function update(ThemePreset $themePreset): bool;
    public function delete(int $themePresetID): bool;
}
