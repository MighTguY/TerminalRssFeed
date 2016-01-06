<?php
include_once 'RssReader.php';
class RssConfig {

	private $rssMap         = array();
	private $configMap      = array();
	private $configFileName = "";
    public function __construct($config = ".news/config/config.ini") {
        $home = getenv('USER');
        $config = $home."/".$config;        
		if (!file_exists($config)) {
			error_log("The file is not present $config ");
			exit;
		}
		$this->configMap = parse_ini_file($config, true);
		$this->doPrepareRssMap();
	}

	public function getRssReader($rssType = "news", &$rssReader) {

		$result  = true;
		$rssType = strtolower($rssType);
		if (array_key_exists($rssType, $this->rssMap)) {
			$rssReader = $this->rssMap[$rssType];
		} else {
			$result = false;
			error_log("unable to find $rssType in map ");
		}
		return $result;
	}

	public function getRandomRssReader(&$rssReader) {

		$key       = array_rand($this->rssMap);
		$rssReader = $this->rssMap[$key];
		return $key;
	}

	private function doPrepareRssMap() {

		foreach ($this->configMap['url'] as $k => $v) {
			$k        = strtolower($k);
			$fileName = $k.".json";
			$obj      = new RssReader($fileName, $this->configMap['url'][$k]);
			error_log("key [".$k."] =>  URL [".$this->configMap['url'][$k]."]");
			$this->rssMap[$k] = $obj;

		}
	}

	public function callOnLoadALL() {

		foreach ($this->rssMap as $k => $v) {
			$this->rssMap[$k]->doLoadNews($this->configMap['url'][$k]);
		}
	}

	public function getAllFunctions() {
		return $this->configMap['functions'];
	}

}
?>
