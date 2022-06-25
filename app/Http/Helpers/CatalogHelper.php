<?php

namespace App\Http\Helpers;

use App\Models\Catalog;

class CatalogHelper
{
    public static function getIdsByParentId(int $id): array
    {
        $cat = Catalog::query()
            ->where('id', $id)
            ->with([
                'children:id,parent_id',
                'children.children:id,parent_id',
            ])
            ->first();

        return [$id] + self::getIds($cat->children);
    }

    private static function getIds ($collection): array
    {
        $ids = [];
        foreach ($collection as $item) {
            $ids[] = $item->id;
            $ids = array_merge($ids, self::getIds($item->children));
        }

        return $ids;
    }
}
