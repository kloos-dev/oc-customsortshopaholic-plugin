<?php namespace Codecycler\CustomSortShopaholic\Classes\Event;

use Lovata\Shopaholic\Controllers\Products;

class ExtendProductController
{
    public function subscribe()
    {
        Products::extend(function ($obController) {
            array_push($obController->implement, 'Codecycler.CustomSortShopaholic.Behaviors.ReorderController');

            $obController->addDynamicMethod('reorder', function () {
            });

            $obController->addDynamicMethod('reorderRender', function () {
                return $this->reorderRender();
            });

            $obController->addDynamicProperty('reorderConfig', '$/codecycler/customsortshopaholic/config/reorder.yaml');
        });
    }
}