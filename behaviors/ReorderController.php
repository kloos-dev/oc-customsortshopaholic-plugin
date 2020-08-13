<?php namespace Codecycler\CustomSortShopaholic\Behaviors;

use Backend\Behaviors\ReorderController as BehaviorsReorderController;

class ReorderController extends BehaviorsReorderController
{
    protected function validateModel()
    {
        $model = $this->controller->reorderGetModel();

        $this->sortMode = 'simple';

        return $model;
    }
}