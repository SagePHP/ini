<?php

namespace SagePHP\Component\Parser\Ini;

use SagePHP\Component\Parser\Ini\Node\SectionNode;
use SagePHP\Component\Parser\Ini\Node\CommentNode;
use SagePHP\Component\Parser\Ini\Node\KeyValueNode;
use SagePHP\Component\Parser\Ini\Node\NodeInterface;

class Ini
{
    /**
     * the contents to parse
     *
     * @var string
     */
    private $content;

    /**
     * the compiler in use
     *
     * @var Compiler
     */
    private $compiler;

    private $data;

    private function getData()
    {
        if (null === $this->data) {
            $this->data = $this->getCompiler()->parse($this->getContent());
        }

        return $this->data;
    }

    public function __construct($content = '')
    {
        $this->setContent($content);
    }

    /**
     * Gets the the contents to parse.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Sets the the contents to parse.
     *
     * @param string $content the content
     *
     * @return self
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Generetes a new compilr class
     *
     * @return Compiler
     */
    protected function getCompiler()
    {
        if (null === $this->compiler) {
            $compiler = new Compiler;
            $compiler->registerNode(new SectionNode);
            $compiler->registerNode(new CommentNode);
            $compiler->registerNode(new KeyValueNode);

            $this->compiler = $compiler;
        }

        return $compiler;
    }

    /**
     * Sets the the compiler in use.
     *
     * @param Compiler $compiler the compiler
     *
     * @return self
     */
    public function setCompiler(Compiler $compiler)
    {
        $this->compiler = $compiler;

        return $this;
    }

    /**
     * array representation of the file structure
     *
     * @return array
     */
    public function toArray()
    {

        $return = array();
        $currentSection = null;

        foreach ($this->getData() as $node) {
            $key   = $node->getKey();
            $value = $node->getValue();

            if ($node instanceof SectionNode) {
                $currentSection = $node->getValue();
                $return[$currentSection] = array();
                continue;
            }

            if (null === $currentSection) {
                if (null === $key) {
                    $return[] = $value;
                } else {
                    $return[$key] = $value;
                }

            } else {
                if (null === $key) {
                    $return[$currentSection][] = $value;
                } else {
                    $return[$currentSection][$key] = $value;
                }
            }

        }


        return $return;
    }

    /**
     * alias for __toSTring
     *
     * @see self::__toSTring()
     * @return string
     */
    public function toString()
    {
        return $this->__toString();
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function __toString()
    {

        return implode("\n", $this->getData());

    }

    /**
     * returns true if the section is present
     *
     * @param  string  $section
     *
     * @return boolean
     */
    public function hasSection($section)
    {
        $data = $this->toArray();

        return array_key_exists($section, $data) && is_array($data[$section]);
    }

    /**
     * returns true if the key is present
     *
     * @param  string       $key
     * @param  string|null  $section
     *
     * @return boolean
     */
    public function hasKey($key, $section = null)
    {
        $data = $this->toArray();

        if (null === $section) {

            return array_key_exists($key, $data);
        }

        if (true === $this->hasSection($section)) {

            return array_key_exists($key, $data[$section]);
        }

        return false;
    }

    public function get($key, $section = null)
    {
        $data = $this->toArray();

        if (false === $this->hasKey($key, $section)) {
            return null;
        }

        if (null === $section) {
            return $data[$key];
        }

        return $data[$section][$key];
    }

    /**
     * adds a key/value node
     *
     * @param string $key
     * @param string $value
     * @param string $section
     * @param string $comment
     */
    public function set ($key, $value, $section = null, $comment = '')
    {
        if ($this->hasKey($key, $section)) {
            $this->remove($key, $section);
        }

        if (strlen($comment) > 0) {
            $comment = ' ; ' . $comment;
        }

        $node = new KeyValueNode;
        $node->setContent($key . '='.$value . $comment);

        $this->appendToSection($node, $section);
    }

    public function remove ($key, $section = null)
    {
        $structure = $this->getData();
        $itemCount = count($structure);

        $inCorrectSection = null === $section;
        $currentSection = null;

        for ($n = 0; $n < $itemCount; $n++) {
            $currNode = $structure[$n];
            if ($currNode instanceof SectionNode) {
                $currentSection = $currNode->getValue();
                $inCorrectSection = $currentSection == $section;
            }

            if ($currNode instanceof KeyValueNode && $inCorrectSection) {
                array_splice($structure, $n, 1);
                break;
            }
        }

        $this->data = $structure;

    }

    private function appendToSection(NodeInterface $node, $section = null)
    {
        $structure = $this->getData();
        $itemCount = count($structure);

        if (false === $this->hasSection($section) && null !== $section) {
            $newSection = new SectionNode;
            $newSection->setContent("[$section]");
            $structure[] = $newSection;
        }

        $inCorrectSection = null === $section;
        $currentSection = null;
        $added = false;
        for ($n = 0; $n < $itemCount; $n++) {
            $currNode = $structure[$n];
            if ($currNode instanceof SectionNode) {
                if ($inCorrectSection) {
                    array_splice($structure, $n, 0, array($node));
                    $added = true;
                    break;
                }
                $currentSection = $currNode->getValue();
                $inCorrectSection = $currentSection == $section;
            }
        }

        // for when we want to append to the last section ....
        if (false === $added) {
            $structure[] = $node;
        }
        $this->data = $structure;
    }
}
