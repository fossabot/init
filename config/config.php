<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    'ROOT_EMAIL'    =>  env('ROOT_EMAIL', 'root@root.com'),
    'ROOT_PASSWORD'    =>  env('ROOT_PASSWORD', 'root'),
    'ROOT_NAME'    =>  env('ROOT_NAME', 'Root'),
    'ROOT_SURNAME'    =>  env('ROOT_SURNAME', 'Root'),
    'TOKEN_EXPIRE'  =>  env('TOKEN_EXPIRE', 1440)
];
