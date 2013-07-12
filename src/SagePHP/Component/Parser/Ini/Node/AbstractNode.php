<?php

namespace SagePHP\Component\Parser\Ini\Node;

abstract class AbstractNode implements NodeInterface
{
    private $key;
    private $value;
    private $content;

    abstract public function __toSTring();
    abstract public function appliesToLine($line);


    /**
     * Gets the value of key.
     *
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Sets the value of key.
     *
     * @param mixed $key the key
     *
     * @return self
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Gets the value of value.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Sets the value of value.
     *
     * @param mixed $value the value
     *
     * @return self
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
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
        if (false === $this->appliesToLine($content)) {
            throw new \LogicException('Node does not apply to this content');
        }

        $this->content = $content;

        return $this;
    }
}
