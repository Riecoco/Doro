<?php

namespace App\Models;

use App\Framework\Annotations\Required;
use App\Framework\Model;

class ThemePreset extends Model
{
    public ?int $themePresetID;
    #[Required]
    public string $name;
    public ?string $bgImgFilePath;
    public ?string $bgImgFileName;
    #[Required]
    public string $primaryColor;
    #[Required]
    public string $bgColor;
    #[Required]
    public string $textColor;
    #[Required]
    public string $accentColor;

    public function __construct(array $data = [])
    {
        $this->themePresetID = $data['themePresetID'] ?? null;
        $this->name = $data['name'] ?? '';
        $this->bgImgFilePath = $data['bgImgFilePath'] ?? null;
        $this->bgImgFileName = $data['bgImgFileName'] ?? null;
        $this->primaryColor = $data['primaryColor'] ?? '';
        $this->bgColor = $data['bgColor'] ?? '';
        $this->textColor = $data['textColor'] ?? '';
        $this->accentColor = $data['accentColor'] ?? '';
    }
}
