<?php
error_reporting(0);
/**
 * Author  : Marcus Tan
 * Name    : Shopee Scraper
 * Version : 1.0
 * Update  : 02 May 2020
 *
 * Credits to WAHYU ARIF PURNOMO, 2019.
 * If you are a reliable programmer or the best developer, please don't change anything.
 * If you want to be appreciated by others, then don't change anything in this script.
 * Please respect me for making this tool from the beginning.
 */
unlink('data/json/results.json');
require __DIR__ . '/vendor/autoload.php';
include "modules/function.php";

use \Curl\Curl;

$curl = new Curl();
$banner = "
@@@@@@@@@@@@((((((@@@@@@@@@@@ 
@@@@@@@@@@((#@@@@((%@@@@@@@@@
@@@@@@@@@((@@@@@@@@(&@@@@@@@@
@@@@@@@@#(@@@@@@@@@&(%@@@@@@@
@(((((((((((((//(((((((((((((
@((((((((((  ((((/ (((((((((( | AUTHOR : MARCUS TAN
@(((((((((( ((((((((((((((((( | NAME   : SHOPEE SCRAPER
@((((((((((/  /(((((((((((((( | VERSION: 1.0
@((((((((((((((/  .(((((((((( | UPDATE : 02 MAY 2020
@(((((((((((((((((. ((((((((#
@#(((((((( (((((((. ((((((((@
@@(((((((((,       (((((((((@
@@((((((((((((((((((((((((((@
@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
";
print $banner;
echo "\nPlease enter product name to search on Shopee.my? ";
$search = trim(fgets(STDIN));

echo "How many # of products data to retrieve? ";
$totalSearch = trim(fgets(STDIN));

$getSearch = getSearch($curl, $search, $totalSearch);
if($getSearch->error == null) {
    $no = 0;
    for ($x = 0; $x < $totalSearch; $x++) {
        $no++;
        $itemID = $getSearch->items[$x]->itemid;
        $shopID = $getSearch->items[$x]->shopid;

        $getItem = getItem($curl, $itemID, $shopID);
            $nameItem = $getItem->item->name;
            $priceItem = $getItem->item->price;
            $discountItem = $getItem->item->discount;
            $statusItem = $getItem->item->item_status;
            $locationToko = $getItem->item->shop_location;
            $imageItem = 'https://cf.shopee.com.my/file/' . $getItem->item->image;

            if($statusItem == "normal") {
                $status = "Available";
            } else {
                $status = "Out of stock";
            }
            echo $no . '. [' . $status . '] [' . $priceItem . '] [' . $nameItem . '] [' . $locationToko . '] [' . $imageItem . "] \n";

            $export['data'][] = array(
                    'no' => $no,
                    'status' => $status,
                    'name' => $nameItem,
                    'price' => $priceItem,
                    'location' => $lokasiToko,
                    'image' => $imageItem,
                    'status' => $status
                );
            //echo json_encode($export) . "\n";
            if (($id = fopen('data/json/results.json', 'wb'))) {
                fwrite($id, json_encode($export));
                fclose($id);
            }
        }
    } 
    ob_start();
    htmlConverter();
    $htmlResults = ob_get_contents();
    ob_end_clean(); 
    file_put_contents("data/html/results.html", $htmlResults);
    
    echo "\n\e[0;32mSuccessfully scrape data from Shopee.\e[0m\n\n";
    echo "\e[0;31mFile saved :\n";
    echo "JSON : data/json/results.json\n";
    echo "HTML : data/html/results.html\e[0m";
    
/**
 * Author  : Marcus Tan
 * Name    : Shopee Scraper
 * Version : 1.0
 * Update  : 02 May 2020
 *
 * Credits to WAHYU ARIF PURNOMO, 2019.
 * If you are a reliable programmer or the best developer, please don't change anything.
 * If you want to be appreciated by others, then don't change anything in this script.
 * Please respect me for making this tool from the beginning.
 */
?>
