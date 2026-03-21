<?php

namespace App\Repositories;

use App\Framework\Repository;
use App\Models\ThemePreset;
use App\Repositories\Interfaces\IThemePresetRepository;

class ThemePresetRepository extends Repository implements IThemePresetRepository
{
    /**
     * @return ThemePreset[]
     */
    public function getAllThemePresets(): array
    {
        $sql = 'SELECT * FROM ThemePresets';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, ThemePreset::class);
    }

    public function getThemePresetById(int $themePresetID): ?ThemePreset
    {
        $sql = 'SELECT * FROM ThemePresets WHERE themePresetID = :themePresetID';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute(['themePresetID' => $themePresetID]);
        $result = $stmt->fetchObject(ThemePreset::class);
        return $result ?: null;
    }

    public function createThemePreset(ThemePreset $themePreset, int $userID): int
    {
        $sql = 'INSERT INTO ThemePresets 
                            (name, bgImgFilePath, bgImgFileName, primaryColor, 
                            bgColor, textColor, accentColor, userID) 
                VALUES (:name, :bgImgFilePath, :bgImgFileName, :primaryColor, 
                        :bgColor, :textColor, :accentColor, :userID)';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindValue(':name', $themePreset->name, \PDO::PARAM_STR);
        $stmt->bindValue(':bgImgFilePath', $themePreset->bgImgFilePath, \PDO::PARAM_STR);
        $stmt->bindValue(':bgImgFileName', $themePreset->bgImgFileName, \PDO::PARAM_STR);
        $stmt->bindValue(':primaryColor', $themePreset->primaryColor, \PDO::PARAM_STR);
        $stmt->bindValue(':bgColor', $themePreset->bgColor, \PDO::PARAM_STR);
        $stmt->bindValue(':textColor', $themePreset->textColor, \PDO::PARAM_STR);
        $stmt->bindValue(':accentColor', $themePreset->accentColor, \PDO::PARAM_STR);
        $stmt->bindValue(':userID', $userID, \PDO::PARAM_INT);
        $stmt->execute();
        return (int)$this->getConnection()->lastInsertId();
    }

    public function updateThemePreset(ThemePreset $themePreset): bool
    {
        $sql = 'UPDATE ThemePresets 
                SET name = :name, bgImgFilePath = :bgImgFilePath, bgImgFileName = :bgImgFileName, 
                            primaryColor = :primaryColor, bgColor = :bgColor, textColor = :textColor, 
                            accentColor = :accentColor 
                WHERE themePresetID = :themePresetID';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindValue(':name', $themePreset->name, \PDO::PARAM_STR);
        $stmt->bindValue(':bgImgFilePath', $themePreset->bgImgFilePath, \PDO::PARAM_STR);
        $stmt->bindValue(':bgImgFileName', $themePreset->bgImgFileName, \PDO::PARAM_STR);
        $stmt->bindValue(':primaryColor', $themePreset->primaryColor, \PDO::PARAM_STR);
        $stmt->bindValue(':bgColor', $themePreset->bgColor, \PDO::PARAM_STR);
        $stmt->bindValue(':textColor', $themePreset->textColor, \PDO::PARAM_STR);
        $stmt->bindValue(':accentColor', $themePreset->accentColor, \PDO::PARAM_STR);
        $stmt->bindValue(':themePresetID', $themePreset->themePresetID, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteThemePreset(int $themePresetID): bool
    {
        $sql = 'DELETE FROM ThemePresets WHERE themePresetID = :themePresetID';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindValue(':themePresetID', $themePresetID, \PDO::PARAM_INT);
        return $stmt->execute();
    }
}
