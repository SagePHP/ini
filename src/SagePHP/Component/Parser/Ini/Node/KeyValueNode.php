<?php

namespace SagePHP\Component\Parser\Ini\Node;

class KeyValueNode extends AbstractNode
{
    private $comment = '';

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Key Value node';
    }

    /**
     * sets the comment for this line
     *
     * @param string $comment
     */
    private function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * returns the formatted comment is any
     *
     * @return string
     */
    private function getComment()
    {
        if (strlen($this->comment)> 0) {
            return '; ' . $this->comment;
        }

        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function appliesToLine($line)
    {
        return preg_match('/^(?![ ]{0,}\;).*\=.*/', $line) === 1;
    }

    /**
     * {@inheritdoc}
     */
    public function setContent($content)
    {
        parent::setContent($content);
        $content = parent::getContent();

        $parts = explode('=', $content);
        $key = trim($parts[0]);
        list($value, $comment) = $this->processValue(isset($parts[1]) ? $parts[1] : null);

        $this->setKey($key);
        $this->setValue($value);
        $this->setComment($comment);
    }

    /**
     * processes the value field including comments
     *
     * @param  string $value
     *
     * @return array
     */
    private function processValue($value)
    {

        $test = rtrim(trim($value), ';') . ';';
        preg_match('/(".*"|.*?);(.*)/', $test, $matches);
        $value = trim(isset($matches[1]) ? $matches[1] : $value);
        $comment = isset($matches[2]) ? trim($matches[2], '; ') : '';

        return array($value, $comment);
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return trim($this->getKey() . ' = ' . $this->getValue() . ' ' . $this->getComment());
    }
}
