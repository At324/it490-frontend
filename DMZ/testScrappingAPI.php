<?php
        $url = "https://www.newegg.com/Product/ProductList.aspx?Submit=ENE&N=-1&IsNodeId=1&Description=desktop%20graphics%20card&bop=And&PageSize=96&order=RATING";
        $html = file_get_contents($url);
        if (preg_match("\item-container >/s(.*?)/s<item-operate >/", $html, $html_arr) === 0){
//      $img = explode('src', $html_arr[1]);
//      $img = explode("", $img[1]);
//      $img = "https:".$img[1];
        echo "found";
        echo $html_arr[0];
}
else{

        echo "not found";
}
?>
