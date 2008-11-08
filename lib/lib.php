<?php

/**
 * Generates a playlist for a single file
 *
 * @param array $file_attributes
 * @param string $playlist_type
 *
 * @return string playlist file contents
 */
function get_playlist_file_single($file_attributes, $playlist_type = 'xspf')
{
    $url = '';

    if (isset($file_attributes['url'])) {
        $url .= $file_attributes['url'];
    } else {
        //  Each component (examples are space-delimited) of a URL such as http:// www.example.com :8000 /audio/lecture/aqeedah / 001.ogg
        $url .= isset($file_attributes['protocol']) ? $file_attributes['protocol'] . '://' : '';    //  e.g., http, ftp, file, etc.
        $url .= isset($file_attributes['hostname']) ? $file_attributes['hostname'] : '';    //  e.g., www.example.com
        $url .= isset($file_attributes['path']) ? $file_attributes['path'] : '';    //  e.g., /audio/lecture/aqeedah
        $url .= isset($file_attributes['port']) ? ':' . $file_attributes['port'] : '';    //  e.g., :8000
        $url .= isset($file_attributes['path']) ? '/' : ''; //  in the case that path was specified above, adds the final '/' before the filename itself
        $url .= isset($file_attributes['filename']) ? $file_attributes['filename'] : '';    //  e.g., 001.ogg
    }

    $playlist_contents = '';

    switch ($playlist_type) {
        default:
            break;
        case 'm3u':
            $playlist_contents .= "#EXTM3U\n\n";

            if (isset($file_attributes['title'])) {
                $playlist_contents .= "#EXTINF:-1,{$file_attributes['title']}\n";
                $playlist_contents .= "$url\n";
            }
            break;
        case 'xspf':
            $xspf = new DOMDocument('1.0', 'UTF-8');
            $xspf->formatOutput = true;

            $xspf->appendChild($playlist = $xspf->createElement('playlist'));
            $playlist->setAttribute('version', '1');
            $playlist->setAttribute('xmlns', 'http://xspf.org/ns/0/');

            $playlist->appendChild($trackList = $xspf->createElement('trackList'));

            $trackList->appendChild($track = $xspf->createElement('track'));

            $track->appendChild($location = $xspf->createElement('location', $url));

            if (isset($file_attributes['title'])) {
                $track->appendChild($title = $xspf->createElement('title', $file_attributes['title']));
            }

            if (isset($file_attributes['creator'])) {
                $track->appendChild($creator = $xspf->createElement('creator', $file_attributes['creator']));
            }

            if (isset($file_attributes['album'])) {
                $track->appendChild($album = $xspf->createElement('album', $file_attributes['album']));
            }

            $playlist_contents = $xspf->saveXML();
            break;
    }

    return $playlist_contents;
}
