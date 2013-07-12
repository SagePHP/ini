<?php

namespace SagePHP\Component\Parser\Ini\Node;

interface NodeInterface
{
    public function setContent($content);
    public function getKey();
    public function getValue();
    public function __toSTring();
    public function appliesToLine($line);
    public function getName();
}
