<?php

namespace App\Helpers;

use App\Models\DetailPatrolConfig;

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
        $config = DetailPatrolConfig::with('event')
            ->whereIdCompany($idCompany)
            ->whereParentId($parentId)
            ->get()
            ->toArray();
        if (count($config) > 0) {
            $result = array_merge($result, $config);
            foreach ($config as $item) {
                $child = self::getFlattenConfig($idCompany, $item['id_detail_patrol_config']);
                $result = array_merge($result, $child);
            }
        }
        return $result;
    }
}
