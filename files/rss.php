<?php
include_once 'RssConfig.php';
include_once 'Colors.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function filterHtmlText($str) {
	$filtered = preg_replace("/<(.*?)\>/", "", $str);
	$filtered = preg_replace("/&nbsp;/", "", $filtered);
	$filtered = preg_replace("/&#8217;/", "'", $filtered);
	$filtered = preg_replace("/&hellip;/", "...", $filtered);
	$filtered = preg_replace("/&#8230;/", "...", $filtered);
	$filtered = preg_replace("/&#8216;/", "'", $filtered);
	$filtered = preg_replace("/&#8217;/", "'", $filtered);
	$filtered = preg_replace("/&#8220;/", "“", $filtered);
	$filtered = preg_replace("/&#8221;/", "“", $filtered);
	$filtered = preg_replace("/&#8212;/", "—", $filtered);

	return $filtered;

}

function getNews(&$feed1_title, &$feed1_pubdate, &$feed1_desc, &$totalfeedNews, $feed_rss) {

	// if (!$objConfig->getRssReader("news", $obj)) {
	// 	exit;
	// }
	// $feed_rss = $obj->getFeedArray();

	$totalfeedNews = count($feed_rss->channel->item);
	$min           = 0;
	$max           = $totalfeedNews-1;
	$index         = rand($min, $max);
	$feed1_title   = $feed_rss->channel->item[$index]->title."\n";
	$feed1_pubdate = $feed_rss->channel->item[$index]->pubDate."\n \n \n";
	$feed1_desc    = $feed_rss->channel->item[$index]->description."\n";
	$feed1_desc    = filterHtmlText($feed1_desc);

	$feed1_pubdate = new DateTime($feed_rss->channel->item[$index]->pubDate);
	$feed1_pubdate->setTimezone(new DateTimeZone('Asia/Kolkata'));

}

function getTechNews(&$feed1_title, &$feed1_pubdate, &$feed1_desc, &$totalfeedNews, $feed_rss) {

	// if (!$objConfig->getRssReader("techcrunch", $obj)) {
	// 	exit;
	// }
	// $feed_rss      = $obj->getFeedArray();
	$totalfeedNews = count($feed_rss->channel->item);
	$min           = 0;
	$max           = $totalfeedNews-1;
	$index         = rand($min, $max);
	$feed1_title   = $feed_rss->channel->item[$index]->title."\n";
	$feed1_pubdate = $feed_rss->channel->item[$index]->pubDate."\n \n \n";
	$feed1_desc    = $feed_rss->channel->item[$index]->description."\n";
	$feed1_desc    = filterHtmlText($feed1_desc);
	//$desc       = strstr($feed1_desc, '<', true);
	//$feed1_desc = $desc."\n";

	$feed1_pubdate = new DateTime($feed_rss->channel->item[$index]->pubDate);
	$feed1_pubdate->setTimezone(new DateTimeZone('Asia/Kolkata'));

}

function display(&$feed1_title, &$feed1_pubdate, &$feed1_desc, &$totalfeedNews, $feed_rss, $feedFrom, $source) {

	$colors      = new Colors();
	$feed1_title = $colors->getColoredString($feed1_title, "yellow");
	$feed1_desc  = $colors->getColoredString($feed1_desc, "blue", "light_gray");
	$source      = strtoupper($source);
	$source      = $colors->getColoredString($source, "white", "red");
	print$feed1_title;
	print$feed1_pubdate->format('d-m-Y H:i A')."\n";
	print$feed1_desc;
	print"Source :".$source."\n";

}

$feed1_title   = "";
$feed1_desc    = "";
$feed1_pubdate = "";
$feed1_from    = "";
$totalfeedNews = 0;

$objConfig     = new RssConfig();
$functionArray = $objConfig->getAllFunctions();
$feed_rss_type = $objConfig->getRandomRssReader($feed_rssObj);
$feed_rss      = $feed_rssObj->getFeedArray();

//print$feed_rss_type."\n";
//print_r($feed_rss);
//print_r($functionArray);
// print("
// __        __   _
// \ \      / /__| | ___ ___  _ __ ___   ___
//  \ \ /\ / / _ \ |/ __/ _ \| '_ ` _ \ / _ \
//   \ V  V /  __/ | (_| (_) | | | | | |  __/
//    \_/\_/ \___|_|\___\___/|_| |_| |_|\___|

// \n ");
if (array_key_exists($feed_rss_type, $functionArray)) {
	$functionArray[$feed_rss_type]($feed1_title, $feed1_pubdate, $feed1_desc, $totalfeedNews, $feed_rss);
	//getNews($feed1_title, $feed1_pubdate, $feed1_desc, $totalfeedNews, $objConfig);
	//getTechNews($feed1_title, $feed1_pubdate, $feed1_desc, $totalfeedNews, $objConfig);
	display($feed1_title, $feed1_pubdate, $feed1_desc, $totalfeedNews, $objConfig, $feed1_from, $feed_rss_type);
}
	else 
		error_log("No key found in functionArray for ".$feed_rss_type)

?>
