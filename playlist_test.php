<?php

require_once 'lib/lib.php';

// http://www.audioislam.com//audio/quran/recitation/sahl-bin-zayn-yaaseen/002.mp3

$file_attributes = array(
    'protocol'  => 'http',
    'hostname'  => 'www.audioislam.com',
    'path'      => '/audio/quran/recitation/sahl-bin-zayn-yaaseen',
    'filename'  => '002.mp3',
    'title'     => 'Soorat Albaqarah',
    'creator'   => 'Sahl bin Zayn Yaaseen',
    'album'     => 'Alqur\'aan',
);

echo get_playlist_file_single($file_attributes, 'm3u');
