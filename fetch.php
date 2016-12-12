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

    $file = file_get_contents('http://wrap.edev.frokost.dk/cater/'.$cater);
    $html = new simple_html_dom();
    $html->load($file);

    foreach($html->find("div[class=weekMenu] div div[id=" . $weekdays[$weekday]. "]") as $tr) {
        $menu = $tr->innertext();
    }

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: ' . $from . "\r\n";
    mail($to ,'Dagens menu for ' . date('l j. F Y') , $menu, $headers);

}
