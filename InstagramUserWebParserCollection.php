<?php

include_once("autoload.php");

class InstagramUserWebParserCollection {

	protected $urls = array();
	protected $collection = array();

	public function __construct($list = "urls.list") {
		if(file_exists($list)) {
			$this->urls = file($list);
		}
		if(is_array($list)) {
			$this->urls = $list;
		}
		$this->load();
	}

	protected function load() {
		if(is_array($this->urls)) {
			foreach($this->urls as $url) {
				$url = new InstagramUserWebParser($url);
				$this->collection[] = $url->fetchUrl()->parseOutJson();
			}
		}
	}

	public function getRecentPhotos() {
		$ret = array();
		if(!empty($this->collection)) {
			foreach($this->collection as $i) {
				$ret[$i->getUrl()] = $i->getRecentPhotos();
			}
		}
		return $ret;
	}
}
