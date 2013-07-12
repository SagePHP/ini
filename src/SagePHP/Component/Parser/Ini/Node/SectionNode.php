<?php

namespace SagePHP\Component\Parser\Ini\Node;

class SectionNode extends AbstractNode
{
     /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Section node';
    }

    /**
     * {@inheritdoc}
     */
    public function appliesToLine($line)
    {
        return preg_match('/^( ){0,}\[.*\]/', $line) === 1;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return sprintf("\n[%s]", $this->getValue());
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
        $value = trim($this->getContent(), ' []');
        if (null === $value) {
            throw new \IncvalidArgumentException('Could not parse line, no section found');
        }

        return $value;
    }
}
