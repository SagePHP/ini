<?php

namespace SagePHP\Component\Parser\Ini\Node;

class CommentNode extends AbstractNode
{
     /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Comment node';
    }

    /**
     * {@inheritdoc}
     */
    public function appliesToLine($line)
    {
        return preg_match('/^( ){0,}\;/', $line) === 1;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return (string) $this->getValue();
    }

    /**
     * {@inheritdoc}
     */
    public function getKey()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return null === ($value = $this->getContent()) ? '' : $value;
    }
}
