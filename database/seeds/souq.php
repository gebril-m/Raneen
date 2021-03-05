<?php

require 'simple_html_dom.php';

function get_products($url) {
    $dom = file_get_html($url);
    echo 'test' ;

    $products = [];
    foreach ($dom->find('.column-block') as $item) {
        $link = $item->find('a', 0)->href;
//        $title = $item->find('a', 0)->{'title'};
//        $category = $item->find('a', 0)->{'data-category-name'};
//        $brand = $item->find('a', 0)->{'data-brand-name'};
//        $itemprice = $item->find('a', 0)->{'data-itemprice'};

        $products[] = [
            'link' => $link,
//            'name' => $title,
//            'category' => $category,
//            'brand' => $brand,
//            'price' => $itemprice,
        ];
    }

   return $products;
}

function get_product($link, $locale = 'ar') {

    if ($locale == 'en') $link = str_replace('-ar/', '-en/', $link);

    $html = getPage($link);
    $ddom = str_get_html($html);
    if (!$ddom) return [
        'title' => '',
        'thumbnail' => '',
        'images' => [],
        'description' => '',
    ];
    $description = $ddom->find('#description-full', 0);

    $_images = $ddom->find('[data-open="product-gallery-modal"] img');
    $images = [];
    foreach ($_images as $i) {
        if (!isset($i->{"data-lazy"}) || !$i->{"data-lazy"}) continue;
        $images[] = $i->{"data-lazy"};
    }

    return [
        'title' => $ddom->find('.product-title h1', 0)->innertext,
        'thumbnail' => $images[0] ?? '',
        'images' => $images,
        'description' => $description->innertext ?? '',
    ];
}

function getPage ($url) {


    $useragent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.89 Safari/537.36';
    $timeout= 120;
    # $dir            = dirname(__FILE__);
    # $cookie_file    = $dir . '/cookies/' . md5($_SERVER['REMOTE_ADDR']) . '.txt';

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_FAILONERROR, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    # curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
    # curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
    curl_setopt($ch, CURLOPT_ENCODING, "" );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt($ch, CURLOPT_AUTOREFERER, true );
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout );
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout );
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10 );
    curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
    curl_setopt($ch, CURLOPT_REFERER, 'http://www.google.com/');
    $content = curl_exec($ch);
    if(curl_errno($ch))
    {
        echo 'error:' . curl_error($ch);
    }
    else
    {
        return $content;
    }
    curl_close($ch);

}
