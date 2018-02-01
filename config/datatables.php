<?php

return [

    'search'          => [
        'case_insensitive' => true,
        'use_wildcards'    => false,
    ],

    'fractal'         => [
        'serializer' => 'League\Fractal\Serializer\DataArraySerializer',
    ],

    'script_template' => 'datatables::script',
    'engines' => [
        'eloquent'   => Yajra\Datatables\Engines\EloquentEngine::class,
        'query'      => Yajra\Datatables\Engines\QueryBuilderEngine::class,
        'collection' => Yajra\Datatables\Engines\CollectionEngine::class,
        // add your custom engine
    ],
];
