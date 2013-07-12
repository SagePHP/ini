<?php

namespace Test\SagePHP\Component\Parser\Ini\Node;

use SagePHP\Component\Parser\Ini\Node\SectionNode;
use SagePHP\Component\Parser\Ini\Node\CommentNode;
use SagePHP\Component\Parser\Ini\Node\KeyValueNode;
use SagePHP\Component\Parser\Ini\Compiler;

class ComplierTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $compiler = new Compiler;
        $compiler->registerNode(new SectionNode);
        $compiler->registerNode(new CommentNode);
        $compiler->registerNode(new KeyValueNode);

        $this->obj = $compiler;
    }

    public function testCompilerSimple()
    {
        $contents = '
; comment 1
no.section.key = 1

[section]
section.key = 2
section.comment = 3 ; comment

        ';

        $data = $this->obj->parse($contents);
        $this->assertEquals(5, count($data));

        $this->assertInstanceOf('SagePHP\Component\Parser\Ini\Node\CommentNode', $data[0]);
        $this->assertEquals('; comment 1', (string)$data[0]);

        $this->assertInstanceOf('SagePHP\Component\Parser\Ini\Node\KeyValueNode', $data[1]);
        $this->assertEquals('no.section.key = 1', (string)$data[1]);

        $this->assertInstanceOf('SagePHP\Component\Parser\Ini\Node\SectionNode', $data[2]);
        $this->assertEquals("\n[section]", (string)$data[2]);

        $this->assertInstanceOf('SagePHP\Component\Parser\Ini\Node\KeyValueNode', $data[3]);
        $this->assertEquals('section.key = 2', (string)$data[3]);

        $this->assertInstanceOf('SagePHP\Component\Parser\Ini\Node\KeyValueNode', $data[4]);
        $this->assertEquals('section.comment = 3 ; comment', (string)$data[4]);

    }
}
