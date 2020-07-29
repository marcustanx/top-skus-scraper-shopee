<?php
/**
 * Author  : Marcus Tan
 * Name    : Shopee Scraper
 * Version : 1.0
 * Update  : 02 May 2020
 * 
 * If you are a reliable programmer or the best developer, please don't change anything.
 * If you want to be appreciated by others, then don't change anything in this script.
 * Please respect me for making this tool from the beginning.
 */
function getSearch($curl, $search, $totalSearch)
{
    $curl->get('https://shopee.com.my/api/v2/search_items/?by=relevancy&keyword=' . $search . '&limit=' . $totalSearch . '&newest=0&order=desc&page_type=search&version=2');

    if ($curl->error) {
        echo 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage . "\n";
    } else {
        //echo 'Response:' . "\n";
        return $curl->response;
    }
}

function getItem($curl, $itemID, $shopID) {
    $curl->get('https://shopee.com.my/api/v2/item/get?itemid=' . $itemID . '&shopid=' . $shopID);

    if ($curl->error) {
        echo 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage . "\n";
    } else {
        //echo 'Response:' . "\n";
        return $curl->response;
    }
}

function htmlConverter() {
    function printHtml($value)
    {
        $data = '';
        $data .= '<td>' . $value . '</td>';

        return $data;
    }
    function printImage($value)
    {
        $data = '';
        $data .='<td><img src="' . $value . '" width="50" height="50"></td>';

        return $data;
    }

    $data = file_get_contents('data/json/results.json');
    $data = json_decode($data, true);

    $date = date("Y-m-d");
    $exportDetail = "'table', '" . $date . "'";

    echo "<html>";
    echo "<head>";
    echo '<script src="tableToExcel.js"></script>';
    echo "<style> table, th, td { border: 1px solid black; border-collapse: collapse; } th, td { padding: 15px; text-align: left; } table#t01 { width: 100%; background-color: #f1f1c1; } footer { font-family: 'Libre Franklin', sans-serif; color: black; } </style>";
    echo "<head>";
    echo "<body>";
    echo '<table id="table" style="width:100%">';
    echo "<tr>";
    echo "<th>No</th>";
    echo "<th>Name</th>";
    echo "<th>Price</th>";
    echo "<th>Location</th>";
    echo "<th>Image</th>";
    echo "<th>Status</th>";
    foreach ($data["data"] as $key => $value) {
        echo "<tr>\n";
        echo printHtml($data['data'][$key]['no']) . "\n";
        echo printHtml($data['data'][$key]['name']) . "\n";
        echo printHtml($data['data'][$key]['price']) . "\n";
        echo printHtml($data['data'][$key]['location']) . "\n";
        echo printImage($data['data'][$key]['image']) . "\n";
        echo printHtml($data['data'][$key]['status']) . "\n";
        echo "</tr>\n";
    }
    echo "</table>";
    echo "<br>";
    echo '<input type="button" onclick="tableToExcel(' . $exportDetail .')" value="Export to Excel">';
    echo "<br>";
    echo '<footer align="center">';
    echo '<a>Copyright @ 2020</a>';
    echo "<br>";
    echo '<a href="https://www.linkedin.com/in/marcustanzw">Marcus Tan</a><a> x Shopee Scraper</a>';
    echo '</footer>';
}
/**
 * Author  : Marcus Tan
 * Name    : Shopee Scraper
 * Version : 1.0
 * Update  : 02 May 2020
 * 
 * If you are a reliable programmer or the best developer, please don't change anything.
 * If you want to be appreciated by others, then don't change anything in this script.
 * Please respect me for making this tool from the beginning.
 */
