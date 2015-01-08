<?php

namespace FeedSplitter\IO;

/**
 * FeedWriter is capable of writing very large xml files without memory concerns
 */
class FeedWriter extends \XMLWriter {

    /**
     * 
     * @param string $path
     * @param string $rootElement
     */
    public function __construct($path, $rootElement = 'root') {
        $this->openUri($path);
        $this->startDocument('1.0', 'UTF-8');
        $this->startElement($rootElement);
        $this->setIndent(TRUE);
    }

    /**
     * Writes Element from DOMElement
     * @todo: currently attributes are not supported
     * @param \DOMElement $element
     * @param bool $flush whether to flush the buffer or not
     */
    public function writeElementFromDOMElement(\DOMElement $element, $flush = TRUE) {
        $this->startElement($element->nodeName);
        foreach ($element->childNodes as $node) {
            if ($node->tagName) {
                $this->writeElement($node->tagName, $node->nodeValue);
            }
        }
        $this->endElement();
        if ($flush) {
            $this->flush();
        }
    }

    /**
     * On Destruct, close the root element
     */
    public function __destruct() {
        $this->endElement();
    }

}