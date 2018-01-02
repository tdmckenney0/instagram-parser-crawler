<?php

include_once("_autoload.php");

class InstagramUserWebParser {

    public $data = "";
    protected $url = "";

    public function __construct($url = null) {
        $this->url = trim($url);
    }

    public function log($msg = "") {
		file_put_contents('InstagramUserWebParser.log', time() . ": " . print_r($msg, true), FILE_APPEND);
    }

	public function getUrl() {
		return $this->url;
	}

    public function fetchUrl() {
        $this->data = file_get_contents($this->url, false);
        return $this;
    }

    public function parseOutJson() {
		try {
			$this->data = explode('window._sharedData = ', $this->data);
			$this->data = array_pop($this->data);
			$this->data = explode(';', $this->data);
			$this->data = array_shift($this->data);
	        $this->data = json_decode($this->data, true);
		} catch(Exception $e) {
			$this->log($e->getMessage());
		}

		return $this;
    }

    public function getRecentPhotos() {
        if(!empty($this->data['entry_data']['ProfilePage'])) {
            try {

				$data = array_pop($this->data['entry_data']['ProfilePage']);

              	ksort($data['user']['media']['nodes']);

              	$col = array_column($data['user']['media']['nodes'], 'id');

				return $col;

            } catch(Exception $e) {
                $this->log($e->getMessage());
            }
        }
        return false;
    }
}
