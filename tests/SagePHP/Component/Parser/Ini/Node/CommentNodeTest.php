<?php

namespace Test\SagePHP\Component\Parser\Ini\Node;

use SagePHP\Component\Parser\Ini\Node\CommentNode;

class CommentNodeTest extends \PHPUnit_Framework_TestCase
{
    public function testAppliesToLine()
    {
        $obj = new CommentNode;

        $this->assertTrue($obj->appliesToLine('; foo'));
        $this->assertFalse($obj->appliesToLine('foo = bar ; foo'));
        $this->assertFalse($obj->appliesToLine('[section]'));
        $this->assertFalse($obj->appliesToLine(''));
    }

    public function testSetContent()
    {
        $obj = new CommentNode;
        $obj->setContent('; comment');
        $this->assertEquals('; comment', $obj->getValue());
        $this->assertEquals('; comment', (string) $obj);
        $this->assertNull($obj->getKey());
    }

    /**
     * @expectedException \LogicException
     */
    public function testSetContentInvalidContent()
    {
        $obj = new CommentNode;
        $obj->setContent('invalid');
    }
}
