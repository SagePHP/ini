<?php

namespace Test\SagePHP\Component\Parser\Ini\Node;

use SagePHP\Component\Parser\Ini\Node\SectionNode;
use SagePHP\Component\Parser\Ini\Node\CommentNode;
use SagePHP\Component\Parser\Ini\Node\KeyValueNode;
use SagePHP\Component\Parser\Ini\Ini;

class IniTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->contents = '
; comment 1
no.section.key = 1

[section]
section.key = 2
section.comment = 3 ; comment

        ';
        $this->obj =  new Ini;
        $this->obj->setContent($this->contents);
    }

    public function testToArraySimple()
    {

        $data = $this->obj->toArray();

        $expected = array(
            '; comment 1',
            'no.section.key' => '1',
            'section' => array(
                'section.key' => '2',
                'section.comment' => '3',
            )
        );

        $this->assertEquals($expected, $data);
    }

    public function testToStringSimple()
    {

        $data = $this->obj->toString();

        $this->assertEquals(trim($this->contents), $data);
    }

    public function testHasSection()
    {
        $this->assertTrue($this->obj->hasSection('section'));
        $this->assertFalse($this->obj->hasSection('no.section.key'));
        $this->assertFalse($this->obj->hasSection('dsfsdfasdfsdf'));

    }

    public function testHasKey()
    {
        $this->assertTrue($this->obj->hasKey('no.section.key'));
        $this->assertTrue($this->obj->hasKey('section.key', 'section'));

        $this->assertFalse($this->obj->hasKey('section.key'));
        $this->assertFalse($this->obj->hasKey('section.key', 'asdsasd'));
    }

    public function testAdd()
    {

        $this->obj->set('add', 'ed', null);
        $expected = array(
            '; comment 1',
            'no.section.key' => '1',
            'add' => 'ed',
            'section' => array(
                'section.key' => '2',
                'section.comment' => '3',
            )
        );
        $this->assertEquals($expected, $this->obj->toArray());



        $this->obj->set('add', 'ed', 'section');
        $expected = array(
            '; comment 1',
            'no.section.key' => '1',
            'add' => 'ed',
            'section' => array(
                'section.key' => '2',
                'section.comment' => '3',
                'add' => 'ed',
            )
        );
        $this->assertEquals($expected, $this->obj->toArray());



        $this->obj->set('add', 'ed', 'foo');
        $expected = array(
            '; comment 1',
            'no.section.key' => '1',
            'add' => 'ed',
            'section' => array(
                'section.key' => '2',
                'section.comment' => '3',
                'add' => 'ed',
            ),
            'foo' => array(
                'add' => 'ed',
            ),
        );
        $this->assertEquals($expected, $this->obj->toArray());

    }

    public function testRemove()
    {
        $this->assertTrue($this->obj->hasKey('section.key', 'section'));
        $this->obj->remove('section.key', 'section');
        $this->assertFalse($this->obj->hasKey('section.key', 'section'));
    }
}
