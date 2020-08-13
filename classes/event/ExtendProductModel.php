<?php namespace Codecycler\CustomSortShopaholic\Classes\Event;

use Lovata\Shopaholic\Models\Product;
use October\Rain\Database\SortableScope;

class ExtendProductModel
{
    public function subscribe()
    {
        Product::extend(function ($obModel) {
            $obModel->addDynamicMethod('bootSortable', function () {
                static::created(function ($model) {
                    $sortOrderColumn = $model->getSortOrderColumn();

                    if (is_null($model->$sortOrderColumn)) {
                        $model->setSortableOrder($model->getKey());
                    }
                });

                static::addGlobalScope(new SortableScope);
            });

            $obModel->addDynamicMethod('setSortableOrder', function ($itemIds, $itemOrders = null) use ($obModel) {
                if (!is_array($itemIds)) {
                    $itemIds = [$itemIds];
                }

                if ($itemOrders === null) {
                    $itemOrders = $itemIds;
                }

                if (count($itemIds) != count($itemOrders)) {
                    throw new Exception('Invalid setSortableOrder call - count of itemIds do not match count of itemOrders');
                }

                foreach ($itemIds as $index => $id) {
                    $order = $itemOrders[$index];
                    $obModel->newQuery()->where($obModel->getKeyName(), $id)->update([$obModel->getSortOrderColumn() => $order]);
                }
            });

            $obModel->addDynamicMethod('getSortOrderColumn', function () {
                return defined('static::SORT_ORDER') ? static::SORT_ORDER : 'sort_order';
            });
        });
    }
}