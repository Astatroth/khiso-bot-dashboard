<?php

return [
    'excluded_groups' => [],
    'trans_functions' => [
        'trans',
        'trans_choice',
        'Lang::get',
        'Lang::choice',
        'Lang::trans',
        'Lang::transChoice',
        '@lang',
        '@choice',
        '__',
        '$trans.get',
        't',
        'tc',
        '$t',
        '$tc',
        'this.$t',
        'this.$tc'
    ],
    'sort_keys'     => false,
];
