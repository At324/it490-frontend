<?php

$url = "https://www.newegg.com/Product/ProductList.aspx?Submit=ENE&N=-1&IsNodeId=1&Description=desktop%20graphics%20card&bop=And&PageSoze=96&order=RATING";

$html = file_get_contents($url);


$delimiter = '#';
$startTag = 'item-container';
$endTag = 'item-operate';
$regex = $delimiter . preg_quote($startTag, $delimiter)
		    . '(.*?)'
		    . preg_quote($endTag, $delimiter)
		    . $delimiter
		    . 's';
preg_match($regex,$html,$html_arr);


$delimiter = '#';
$startTag = '<img   src=';
$endTag = 'title=';
$regex = $delimiter . preg_quote($startTag, $delimiter)
                    . '(.*?)'
                    . preg_quote($endTag, $delimiter)
                    . $delimiter
                    . 's';
preg_match($regex,$html_arr[1],$imgr);

$delimiter = '#';
$startTag = 'icon-premier icon-premier-xsm';
$endTag = '&#40;PX';
$regex = $delimiter . preg_quote($startTag, $delimiter)
                    . '(.*?)'
                    . preg_quote($endTag, $delimiter)
                    . $delimiter
                    . 's';
preg_match($regex,$html_arr[1],$desc);

$delimiter = '#';
$startTag = 'display: none';
$endTag = '&nbsp';
$regex = $delimiter . preg_quote($startTag, $delimiter)
                    . '(.*?)'
                    . preg_quote($endTag, $delimiter)
                    . $delimiter
                    . 's';
preg_match($regex,$html_arr[1],$price);

$price[1] = preg_replace('#</span>#', '', $price[1]);

$price[1] = preg_replace('#</a>#', '', $price[1]);

$price[1] = preg_replace('#</strong>#', '', $price[1]);

$price[1] = preg_replace('#<strong>#', '', $price[1]);

$price[1] = preg_replace('#</sup>#', '', $price[1]);

$price[1] = preg_replace('#<sup>#', '', $price[1]);

$price[1] = preg_replace('/\s+/', '', $price[1]);


//print_r($html_arr[1]);
print_r($imgr[1]);
print_r($desc[1]);
print_r($price[1]);
?>
