<?php

namespace FeedSplitter;

use FeedSplitter\IO\FeedReader;
use FeedSplitter\IO\FeedWriter;

/**
 * Feed Parser takes an xml feed as input and writes xml documents
 * as output of child node's content
 * @author vlaurenzano
 */
class FeedSplitter {

    /**
     * FeedReader Instance
     * @var FeedReader 
     */
    protected $feedReader;

    /**
     * the node we will be extracting and writing to feeds
     * @var string 
     */
    protected $nodeToFilter;

    /**
     * an array of node names to categorize nodeToFilter
     * @var array 
     */
    protected $childNodeFilters;

    /**
     * An array of open feed writers
     * @var array FeedWriter 
     */
    protected $feedWriters = array();

    /**
     * Instantiates all class variables
     * @param string $url
     * @param string $outputDirectory
     * @param string $nodeToFilter
     * @param array $filterNodes
     */
    public function __construct($url, $outputDirectory, $nodeToFilter, array $filterNodes) {
        $this->feedReader = new FeedReader($url);
        $this->outputDirectory = $outputDirectory;
        $this->nodeToFilter = $nodeToFilter;
        $this->childNodeFilters = $filterNodes;
    }

    /**
     * Start the process
     */
    public function __invoke() {
        while ($currentNode = $this->feedReader->getNextNodeOfType($this->nodeToFilter)) {
            $this->processNode($currentNode);
        }
    }

    /**
     * Go through the items in the given element, if they match one of the
     * categories write the element to a feed
     * @param \DOMElement $element
     */
    protected function processNode(\DOMElement $element) {
        foreach ($element->childNodes as $node) {
            if (in_array($node->tagName, $this->childNodeFilters)) {
                //get a document name with basic stripping for valid name
                $documentName = strtolower(str_replace(array(' ', '.', '/', '\\', '&', ','), '', $node->nodeValue));
                if (!isset($this->feedWriters[$documentName])) {
                    $fullPath = $this->outputDirectory . DIRECTORY_SEPARATOR . $documentName . ".xml";
                    $this->feedWriters[$documentName] = new FeedWriter($fullPath, $this->feedReader->rootNode);
                }
                $this->feedWriters[$documentName]->writeElementFromDOMElement($element);
            }
        }
    }

}