<?php

namespace Test\SagePHP\Component\Parser\Ini\Node;

use SagePHP\Component\Parser\Ini\Node\SectionNode;

class SectionNodeTest extends \PHPUnit_Framework_TestCase
{
    public function testAppliesToLine()
    {
        $obj = new SectionNode;

        $this->assertTrue($obj->appliesToLine(' [section]'));
        $this->assertFalse($obj->appliesToLine('foo = bar ; foo'));
        $this->assertFalse($obj->appliesToLine('; comment'));
        $this->assertFalse($obj->appliesToLine('; [ comment]'));
        $this->assertFalse($obj->appliesToLine(''));
    }

    public function testSetContent()
    {
        $obj = new SectionNode;
        $obj->setContent(' [Section]');
        $this->assertEquals('Section', $obj->getValue());
        $this->assertEquals("\n[Section]", (string) $obj);
        $this->assertNull($obj->getKey());
    }

    /**
     * @expectedException \LogicException
     */
    public function testSetContentInvalidContent()
    {
        $obj = new SectionNode;
        $obj->setContent('invalid');
    }
}
