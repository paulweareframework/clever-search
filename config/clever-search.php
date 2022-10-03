<?php

return [

    'file' => 'clever_search',

    'settings-blueprint' => [
        'name' => [
            'display' => 'General',
            'fields' => [
                'clever_search_section_title' => [
                    'type' => 'section',
                    'display' => 'Clever search settings',
                    'instructions' => 'fields and collections to pick from to quick search'
                ],
                'clever_search_which_collection' => [
                    'type' => 'select',
                    'display' => 'Collection',
                    'instructions' => 'Which collection to search?',
                    'validate' => 'required|string',
                    'options' => [
                        'products' => 'Products',
                        'pages' => 'Pages'
                    ]
                ],
                'clever_search_which_fields' => [
                    'type' => 'array',
                    'listable' => false,
                    'display' => 'Collection Fields?',
                    'instructions' => 'Which fields names to clever search against? please get the key names from blueprints',
                    'mode' => 'dynamic',
                    'icon' => 'array',
                ],
                'clever_search_results' => [
                    'type' => 'section',
                    'display' => 'Clever search settings',
                    'instructions' => 'fields and collections to pick from to quick search'
                ],
            ],
        ]
    ]
];
