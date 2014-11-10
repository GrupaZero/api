<?php

Route::filter(
    'isActive',
    function () {
        // $filter = App::make('doctrine')->getFilters()->enable("isActive");
        // $filter->setParameter('isActive', 1);
    }
);
