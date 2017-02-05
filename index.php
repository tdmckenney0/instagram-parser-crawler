<?php

include_once("autoload.php");

$collection = new InstagramUserWebParserCollection();

print_r($collection->getRecentPhotos());
