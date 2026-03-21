<?php

namespace App\Services;

use App\Models\ThemePreset;
use App\Repositories\ThemePresetRepository;
use App\Repositories\Interfaces\IThemePresetRepository;
use App\Services\Interfaces\IThemePresetService;

class ThemePresetService implements IThemePresetService
{
    private IThemePresetRepository $repository;

    public function __construct()
    {
        $this->repository = new ThemePresetRepository();
    }

    public function getAll(): array
    {
        return $this->repository->getAll();
    }

    public function getById(int $themePresetID): ?ThemePreset
    {
        return $this->repository->getById($themePresetID);
    }

    public function create(ThemePreset $themePreset): ThemePreset
    {
        return $this->repository->create($themePreset);
    }

    public function update(ThemePreset $themePreset): bool
    {
        return $this->repository->update($themePreset);
    }

    public function delete(int $themePresetID): bool
    {
        return $this->repository->delete($themePresetID);
    }
}
