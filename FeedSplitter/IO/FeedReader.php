<?php

namespace FeedSplitter\IO;

/**
 * Feed Reader extends XMLReader and is suitable for parsing
 * large XML Files without memory concerns
 */
class FeedReader extends \XMLReader {

    /**
     * The root node of the document
     * @var type 
     */
    public $rootNode;

    /**
     * Pass in the url to start the reader
     * @param string $url
     * @param string $encoding
     */
    public function __construct($url, $encoding = 'UTF-8') {
        $this->open($url, $encoding);
        $this->read();
        $this->rootNode = $this->name;
    }

    /**
     * advances to given node from anywhere
     * @param string $type
     */
    public function advanceToNode($type) {
        while ($this->read()) {
            if ($this->name === $type) {
                return TRUE;
            }
        };
        return FALSE;
    }

    /**
     * Returns the entire next node of given type
     * @param string $type
     * @return \DomElement
     */
    public function getNextNodeOfType($type) {
        //if the current position isn't on the type of node, advanced to the next
        if ($this->name !== $type) {
            if (!$this->advanceToNode($type)) {
                return FALSE;
            }
            return $this->expand();
        }
        if (!$this->next($type)) {
            return FALSE;
        }
        return $this->expand();
    }

}