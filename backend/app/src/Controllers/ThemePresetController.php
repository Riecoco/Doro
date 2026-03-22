<?php

namespace App\Controllers;

use App\Models\ThemePreset;
use App\Framework\Controller;
use App\Services\ThemePresetService;
use App\Services\Interfaces\IThemePresetService;

class ThemePresetController extends Controller
{
    private IThemePresetService $themePresetService;

    public function __construct()
    {
        $this->themePresetService = new ThemePresetService();
    }

    public function getAll()
    {
        try {
            $presets = $this->themePresetService->getAll();
            return $this->sendSuccessResponse($presets);
        } catch (\Exception $e) {
            return $this->sendErrorResponse('Internal server error', 500);
        }
    }

    public function getById($id)
    {
        try {
            $preset = $this->themePresetService->getById($id);
            if (!$preset) {
                return $this->sendErrorResponse('Theme preset not found', 404);
            }
            return $this->sendSuccessResponse($preset);
        } catch (\Exception $e) {
            return $this->sendErrorResponse('Internal server error', 500);
        }
    }

    public function create()
    {
        try {
            $preset = $this->mapPostDataToClass(ThemePreset::class);
            if (empty($preset->name) || empty($preset->primary_color) || empty($preset->secondary_color)) {
                return $this->sendErrorResponse('Name, primary color, and secondary color are required', 400);
            }
            $createdPreset = $this->themePresetService->create($preset);
            return $this->sendSuccessResponse($createdPreset, 201);
        } catch (\Exception $e) {
            return $this->sendErrorResponse('Internal server error', 500);
        }
    }

    public function update($id)
    {
        try {
            $preset = $this->mapPostDataToClass(ThemePreset::class);
            $preset->id = $id;
            if (empty($preset->name) || empty($preset->primary_color) || empty($preset->secondary_color)) {
                return $this->sendErrorResponse('Name, primary color, and secondary color are required', 400);
            }
            $updated = $this->themePresetService->update($preset);
            if (!$updated) {
                return $this->sendErrorResponse('Theme preset not found', 404);
            }
            return $this->sendSuccessResponse(['message' => 'Theme preset updated successfully']);
        } catch (\Exception $e) {
            return $this->sendErrorResponse('Internal server error', 500);
        }
    }

    public function delete($id)
    {
        try {
            $deleted = $this->themePresetService->delete($id);
            if (!$deleted) {
                return $this->sendErrorResponse('Theme preset not found', 404);
            }
            return $this->sendSuccessResponse(['message' => 'Theme preset deleted successfully']);
        } catch (\Exception $e) {
            return $this->sendErrorResponse('Internal server error', 500);
        }
    }
}
