<?php

define('MAIL_FILE', INBOX);

if (! $fp = fopen(MAIL_FILE, 'r')) {
    throw new Exception('Could not open mail file "' . MAIL_FILE . '"');
}

while (! feof($fp)) {
    echo '==========================================================' . "\n";
    echo strlen(mail_get_message($fp));
}

function mail_get_message($fp)
{
    $message = '';
    while (false !== ($line = fgets($fp))) {
        if ('From -' === substr($line, 0, 6)) {
            break;
        }
        $message .= $line;
    }
    return $message;
}
