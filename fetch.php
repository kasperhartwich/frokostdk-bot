<?php
date_default_timezone_set( "Europe/Copenhagen" );
set_time_limit(0);
require('simple_html_dom.php');

$cater = 269;
$from = 'Frokostbot <bot@firma.dk>';
$to = 'frokost@firma.dk';

$weekday = date('N');
$weekdays = [
    1 => 'mon',
    2 => 'tue',
    3 => 'wed',
    4 => 'thu',
    5 => 'fri'
];

if ($weekday<6) {
    $url = "https://www.frokost.dk/frokostordning/koebenhavn/$cater/";
    $file = file_get_contents($url);
    $html = new simple_html_dom();
    $html->load($file);

    $menu = null;
    foreach($html->find("div[class=weekMenu] div div[id=" . $weekdays[$weekday]. "]") as $tr) {
        $menu = $tr->innertext();
    }

    if (!trim(strip_tags($menu))) {
        echo "No menu found\n";
        exit;
    }

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: ' . $from . "\r\n";
    mail($to ,'Dagens menu for ' . date('l j. F Y') , $menu, $headers);

}
