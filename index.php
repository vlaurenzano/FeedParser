<?php
error_reporting( E_ALL ^ E_NOTICE );
spl_autoload_register();
//where we'll get the feed from
$feed = __DIR__ . DIRECTORY_SEPARATOR . 'Data' . DIRECTORY_SEPARATOR . 'Input' . DIRECTORY_SEPARATOR . 'feed.xml';
//where we want to store results
$outputDirectory = __DIR__ . DIRECTORY_SEPARATOR . 'Data' . DIRECTORY_SEPARATOR . 'Output';
//the node we want to filter
$node = 'product';
//the child nodes we want to filter by
$filters = array( 'categoryid1' , 'categoryid2' );
//construct the splitter
$splitter = new FeedSplitter\FeedSplitter( $feed, $outputDirectory, $node, $filters );
//run the process
$splitter();