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
    public function getAll(): array
    {
        $sql = 'SELECT * FROM ThemePresets';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, ThemePreset::class);
    }

    public function getById(int $themePresetID): ?ThemePreset
    {
        $sql = 'SELECT * FROM ThemePresets WHERE themePresetID = :themePresetID';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute(['themePresetID' => $themePresetID]);
        $result = $stmt->fetchObject(ThemePreset::class);
        return $result ?: null;
    }

    public function create(ThemePreset $themePreset): ThemePreset
    {
        $sql = 'INSERT INTO ThemePresets 
                            (name, bgImgFilePath, bgImgFileName, primaryColor, 
                            bgColor, textColor, accentColor) 
                VALUES (:name, :bgImgFilePath, :bgImgFileName, :primaryColor, 
                        :bgColor, :textColor, :accentColor)';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindValue(':name', $themePreset->name, \PDO::PARAM_STR);
        $stmt->bindValue(':bgImgFilePath', $themePreset->bgImgFilePath, \PDO::PARAM_STR);
        $stmt->bindValue(':bgImgFileName', $themePreset->bgImgFileName, \PDO::PARAM_STR);
        $stmt->bindValue(':primaryColor', $themePreset->primaryColor, \PDO::PARAM_STR);
        $stmt->bindValue(':bgColor', $themePreset->bgColor, \PDO::PARAM_STR);
        $stmt->bindValue(':textColor', $themePreset->textColor, \PDO::PARAM_STR);
        $stmt->bindValue(':accentColor', $themePreset->accentColor, \PDO::PARAM_STR);
        $stmt->execute();
        $themePreset->themePresetID = (int)$this->getConnection()->lastInsertId();
        return $this->getById($themePreset->themePresetID);
    }

    public function update(ThemePreset $themePreset): bool
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

    public function delete(int $themePresetID): bool
    {
        $sql = 'DELETE FROM ThemePresets WHERE themePresetID = :themePresetID';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindValue(':themePresetID', $themePresetID, \PDO::PARAM_INT);
        return $stmt->execute();
    }
}
