<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Filehost app settings
    |--------------------------------------------------------------------------
    | General setting for filehost app
    |
    |
    */
    'pagination' => 3,
    'uploadDirectory' => realpath(__DIR__ . '/../uploads/'),
    'files' => [
        // this should be taken from migration
        'maxLengthName' => 500,
        'filesInFolder' => 3,
        'thumbsVsize' => 100,
        'thumbsHsize' => 100,
        'pathToIcons' =>  realpath(__DIR__ . '/../public/icons'),
        'pathToThumbs' =>  realpath(__DIR__ . '/../public/thumbs'),
        'relPathToIcons' => '/icons',
        'relPathToThumbs' => '/thumbs',
        'defaultIcon' => '_blank.png'
    ]

];
