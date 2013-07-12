<?php

namespace SagePHP\Component\Parser\Ini;

use SagePHP\Component\Parser\Ini\Node\NodeInterface;

class Compiler
{
    private $content;
    private $nodes = array();

    /**
     * register a node with the compiler
     *
     * @param  NodeInterface $node
     */
    public function registerNode(NodeInterface $node)
    {
        $this->nodes[] = $node;
    }

    /**
     * returns the registered noded
     *
     * @return NodeInterface[]
     */
    public function getRegisteredNodes()
    {
        return $this->nodes;
    }

    /**
     * parses the ini content and creates a structure
     *
     * @param  string $content
     *
     * @return array
     */
    public function parse($content)
    {
        $lines = explode("\n", $content);

        $data = array();
        $currentSection = null;

        foreach ($lines as $line) {
            $this->processLine($line, $data);
        }

        return $data;
    }

    private function processLine($line, &$data)
    {
        $nodes = $this->getRegisteredNodes();

        foreach ($nodes as $node) {
            if ($node->appliesToLine($line)) {
                $newNode = clone($node);
                $newNode->setContent($line);
                $data[] = $newNode;
                continue;
            }
        }
    }

    /**
     * Gets the value of content.
     *
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Sets the value of content.
     *
     * @param mixed $content the content
     *
     * @return self
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }
}
