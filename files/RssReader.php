<?php
ini_set("log_errors", 1);

$home = getenv('USER');
ini_set("error_log", "$home/.news/logs/php-rssreader.log");

class RssReader {

	private $fileName = "";
	private $fileDir  = "$home/.news/data/";
	private $url      = "";
	private $newsArr  = array();

	public function __construct($fileName = "dataNews.json", $url = "") {
		//setup files
		$this->fileName = $fileName;
		$this->fileName = $this->fileDir."/".$this->fileName;
		if (!file_exists($this->fileDir)) {
			mkdir($this->fileDir, 0777);
			error_log("The directory $this->fileDir was successfully created.");
			$this->doLoadNews($url);
		} else {
			error_log("The directory $this->fileDir exists.");
			if (!file_exists($this->fileName)) {
				$this->doLoadNews($url);
				error_log("The file is created");
			}
		}

	}

	public function getFeedArray() {

		$this->newsArr = json_decode(file_get_contents($this->fileName));
		if (!(count($this->newsArr) > 0)) {
			doLoadNews();
		}

		return $this->newsArr;

	}

	public function setNewsArray($array) {
		$this->newsArr = $array;
	}

	public function doLoadNews($url) {

		//		$this->newsArr = simplexml_load_file('http://dynamic.feedsportal.com/pf/555218/http://toi.timesofindia.indiatimes.com/rssfeedstopstories.cms');
		//echo "get =>".$url."\n";
		$this->newsArr = simplexml_load_file($url);
		file_put_contents($this->fileName, json_encode($this->newsArr));

	}

	public function __toString() {
		return "NEWS ARR ";
		//		print_r($this->newsArr);
	}

}
?>
