<?php

namespace App\Models;

use App\Framework\Model;

class ThemePreset extends Model
{
    public ?int $themePresetID;
    public string $name;
    public string $bgImgFilePath;
    public string $bgImgFileName;
    public string $primaryColor;
    public string $bgColor;
    public string $textColor;
    public string $accentColor;

    public function __construct(array $data = [])
    {
        $this->themePresetID = $data['themePresetID'] ?? null;
        $this->name = $data['name'] ?? '';
        $this->bgImgFilePath = $data['bgImgFilePath'] ?? '';
        $this->bgImgFileName = $data['bgImgFileName'] ?? '';
        $this->primaryColor = $data['primaryColor'] ?? '';
        $this->bgColor = $data['bgColor'] ?? '';
        $this->textColor = $data['textColor'] ?? '';
        $this->accentColor = $data['accentColor'] ?? '';
    }
}
