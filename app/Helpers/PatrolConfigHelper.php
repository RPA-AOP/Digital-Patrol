<?php

namespace App\Helpers;

use App\Models\DetailPatrolConfig;
use App\Models\PatrolConfig;

class PatrolConfigHelper
{
    public static function getNestedConfig($idCompany, $parentId): array
    {
        $result = [];
        $config = DetailPatrolConfig::whereIdCompany($idCompany)->whereParentId($parentId)
            ->get()->toArray();
        if (count($config) > 0) {
            foreach ($config as $item) {
                $item['child'] = self::getNestedConfig($idCompany, $item['id_detail_patrol_config']);
                $result[] = $item;
            }
        }
        return $result;
    }

    public static function getFlattenConfig($idCompany, $parentId): array
    {
        $result = [];
        $level = DetailPatrolConfig::whereIdCompany($idCompany)
            ->whereParentId($parentId)
            ->pluck('level')
            ->first();
        $detailConfig = DetailPatrolConfig::with('event')
            ->whereIdCompany($idCompany)
            ->whereParentId($parentId);

        if ($level == 4) {
            $config = PatrolConfig::where('id_company', $idCompany)->first();
            if ($config->random_checkpoint) {
                $percentage = $config->random_checkpoint_percentage;
                $checkpointsCount = DetailPatrolConfig::where('level', 4)
                    ->whereParentId($parentId)
                    ->where('id_company', $idCompany)->get();
                $randomCheckpoitnCount = $checkpointsCount;
                if (count($checkpointsCount) != 0)
                    $randomCheckpoitnCount = ($percentage / 100) * count($checkpointsCount);

                $detailConfig = $detailConfig->inRandomOrder()
                    ->limit((int)$randomCheckpoitnCount)
                    ->get()
                    ->toArray();
            } else {
                $detailConfig = $detailConfig->get()
                    ->toArray();
            }
        } else {
            $detailConfig = $detailConfig->get()
                ->toArray();
        }

        if (count($detailConfig) > 0) {
            $result = array_merge($result, $detailConfig);
            foreach ($detailConfig as $item) {
                $child = self::getFlattenConfig($idCompany, $item['id_detail_patrol_config']);
                $result = array_merge($result, $child);
            }
        }
        return $result;
    }
}
