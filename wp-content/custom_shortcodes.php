<?php
// check response code
function get_http_response_code($url) {
    $headers = get_headers($url);
    global $result;
    $result = substr($headers[0], 9, 3);
    return $result;
}
/**
 * If the URL stays the same, this will generate the same file name for 1 day. So if changes are made the
 * product after it is cached the changes will be reflected the next day.
 *
 * @param $url
 * @return string
 * @throws Exception
 */
function getPfFileName($url) {
    $dirName  = getFpDirName();
    $fileName = $dirName.DIRECTORY_SEPARATOR.md5($url).'.cache';
    if (true === file_exists($dirName)) {
        fpCacheClean();
    }
    // if (false === mkdir($dirName)) {
    if (false === wp_mkdir_p( $dirName )) {
        // return false;
        throw new Exception("Unable to create cache directory");
    }
    return $fileName;
}
/**
 * If a cache file is greater than $age then it is deleted.
 *
 * 86400 is 24 hours change to make less (3600 is 1 hr)
 */
function fpCacheClean($age=86400){
    $dirName = getFpDirName();
    //Protection from root delete
    if ('/' == $dirName) {
        throw new Exception(sprintf("Root delete protection: %s", $dirName));
    }
    if (true === empty($dirName)) {
        throw new Exception(sprintf("Invalid dir found: %s", $dirName));
    }
    /*** cycle through all files in the directory ***/
    foreach (glob($dirName.DIRECTORY_SEPARATOR."*") as $file) {
        if (filemtime($file) < time() - $age) {
            unlink($file);
        }
    }
}
function getFpDirName()
{
    return 'product_func_cache';
}
/**
 * @param $fileName
 * @return bool|string
 */
function getPfFileContents($fileName)
{
    if (false === file_exists($fileName)) {
        return false;
    }
    $contents = file_get_contents($fileName);
    return (false === $contents && false === empty($contents)) ? false : $contents;
}
// https://gist.github.com/anchetaWern/6150297
function product_func( $atts ) {
    $a = shortcode_atts( array(
        'product_url'   => 'https://www.missguided.co.uk/red-floral-printed-lace-detail-skater-dress-10069755',
        'bar'           => 'something else',
    ), $atts );
    // links OK, get the stuff
    // file_get_contents($a['product_url']);
    $fileName   = getPfFileName($a['product_url']);
    $contents   = getPfFileContents($fileName);
    if (false !== $contents) {
        return $contents;
    }
    $options    = array('http' => array('user_agent' => 'MG-NR-Synthetic'));
    $context    = stream_context_create($options);
    $html       = @file_get_contents( $a['product_url'], false, $context); //get the html returned from the following url
    //If html is false then file_get_contents failed to get the HTML, assumed a 404
    if (false === $html || true === empty($html)) {
        return "<div class='product oos'><a target='_blank' href='https://www.missguided.co.uk/new-in'><p>soz 404</p><button class='button'>shop new in</button></a></div>";
    }
    $product_doc = new DOMDocument();
    libxml_use_internal_errors(TRUE); //disable libxml errors
    $product_doc->loadHTML($html);
    libxml_clear_errors(); //remove errors for yucky html
    $product_xpath  = new DOMXPath($product_doc);
    $product_sale   = $product_xpath->query('//div[@class="product-essential"]/div[@class="product-essential__title"]/div[1]/div[@class="price-box"]/p[@class="old-price"]/span[@class="price"]');
    $product        = $product_xpath->query('//div[@class="product-essential"]/div[@class="product-essential__title"]/div[1]/div[@class="price-box"]//span[@class="price"]');
    if ($product_sale->length > 0) {
        //loop through all the products
        foreach ($product_sale as $pat) {
            //get the name of the product
            $product_title = $product_xpath->query('//h1[contains(@class,"product-name")]', $pat)->item(0)->nodeValue;
            $product_old_price = $product_xpath->query('//div[@class="product-essential"]/div[@class="product-essential__title"]/div[1]/div[@class="price-box"]/p[@class="old-price"]/span[@class="price"]', $pat)->item(0)->nodeValue;
            $product_new_price = $product_xpath->query('//div[@class="product-essential"]/div[@class="product-essential__title"]/div[1]/div[@class="price-box"]/p[@class="special-price"]/span[@class="price"]', $pat)->item(0)->nodeValue;
            //get the full img url
            $product_src = $product_xpath->query('//img[contains(@class,"js-gallery--image-thumb")]/@src', $pat)->item(0)->nodeValue;
            //strip the amp trnsformation
            $findme = '?';
            $pos = strpos($product_src, $findme);
            if ($pos === false) {
                echo "The string '$findme' was not found in the string '$product_src'";
            } else {
                //then add amp transformation we want
                $thumb_size = '?$product-page__thumbnail--3x$';
                $product_img = substr($product_src, 0, $pos) . $thumb_size;
            }
        }
        //output what we have
        return "<div class='product sale'><a target='_blank' href='{$a['product_url']}'><img src='$product_img' alt='product_img'><p class'product_title'>$product_title</p><p><span class'product_price old'>$product_old_price</span><span class'product_price new'>$product_new_price</span></p></a></div>";
    } else if ($product->length > 0) {
        //loop through all the products
        foreach ($product as $pat) {
            //get the name of the product
            $product_title = $product_xpath->query('//h1[contains(@class,"product-name")]', $pat)->item(0)->nodeValue;
            $product_price = $product_xpath->query('//div[@class="product-essential"]/div[@class="product-essential__title"]/div[1]/div[@class="price-box"]//span[@class="price"]', $pat)->item(0)->nodeValue;
            //get the full img url
            $product_src = $product_xpath->query('//img[contains(@class,"js-gallery--image-thumb")]/@src', $pat)->item(0)->nodeValue;
            //strip the amp trnsformation
            $findme = '?';
            $pos = strpos($product_src, $findme);
            if ($pos === false) {
                echo "The string '$findme' was not found in the string '$product_src'";
            } else {
                //then add amp transformation we want
                $thumb_size = '?$product-page__thumbnail--3x$';
                $product_img = substr($product_src, 0, $pos) . $thumb_size;
            }
        }
        //output what we have
        $contents = "<div class='product'><a target='_blank' href='{$a['product_url']}'><img src='$product_img' alt='product_img'><p class'product_title'>$product_title</p><p class'product_price'>$product_price</p></a></div>";
        file_put_contents($fileName, $contents);
        return $contents;
    }
}
?>
