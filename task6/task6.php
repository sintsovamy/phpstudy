<?php
$soundTrack = [
    'title' => 'The Denial Twist',
    'artist' => 'The White Stripes',
    'album' => 'Get Behind Me Satan',
    'year' => '2006',
    'vocals' => [
        'name' => [
            'first_name' => 'Jack',
        ]
    ]
];

var_dump($soundTrack);

$soundTrack['vocals']['name']['second_name'] = 'White';
$soundTrack['vocals']['name']['year'] = '1975';

var_dump($soundTrack);
