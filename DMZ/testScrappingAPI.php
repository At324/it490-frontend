<?php
	set_time_limit(0);

	ignore_user_abort(true);

        $url = "https://www.newegg.com/Product/ProductList.aspx?Submit=ENE&N=-1&IsNodeId=1&Description=desktop%20graphics%20card&bop=And&PageSize=96&order=RATING";
        $html = file_get_contents($url);
      
	if (preg_match_all('/<div class="item-container ">/(.*)\<div class ="item-operate ">/', $html, $html_arr))
{

//      $img = explode('src', $html_arr[1]);
//      $img = explode("", $img[1]);
//      $img = "https:".$img[1];

//	echo $html;
        echo "found";
        print_r($html_arr);
}
else{

        echo "not found";
}
?>
