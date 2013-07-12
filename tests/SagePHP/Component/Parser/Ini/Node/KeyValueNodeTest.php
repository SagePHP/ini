<?php

namespace Test\SagePHP\Component\Parser\Ini\Node;

use SagePHP\Component\Parser\Ini\Node\KeyValueNode;

class KeyValueNodeTest extends \PHPUnit_Framework_TestCase
{
    public function testAppliesToLine()
    {
        $obj = new KeyValueNode;

        $this->assertTrue($obj->appliesToLine('foo = bar ; foo'));
        $this->assertFalse($obj->appliesToLine(';foo = bar ; foo'));
        $this->assertFalse($obj->appliesToLine(' [section]'));
        $this->assertFalse($obj->appliesToLine('; comment'));
        $this->assertFalse($obj->appliesToLine(''));
    }

    public function testSetContent()
    {
        $obj = new KeyValueNode;
        $obj->setContent('foo=bar');
        $this->assertEquals('bar', $obj->getValue());
        $this->assertEquals('foo', $obj->getKey());
        $this->assertEquals('foo = bar', (string) $obj);
    }

    public function testSetContentWithComments()
    {
        $obj = new KeyValueNode;
        $obj->setContent('foo=bar; comment');
        $this->assertEquals('bar', $obj->getValue());
        $this->assertEquals('foo', $obj->getKey());
        $this->assertEquals('foo = bar ; comment', (string) $obj);
    }

    /**
     * @expectedException \LogicException
     */
    public function testSetContentInvalidContent()
    {
        $obj = new KeyValueNode;
        $obj->setContent('; invalid');
    }
}
