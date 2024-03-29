<?php

namespace PMVC\PlugIn\color;

const DEMO_PIC = __DIR__.'/../vendor/pmvc-plugin/image/tests/resource/demo.jpg';

use PMVC\TestCase;

class ColorTest extends TestCase
{
    private $_plug = 'color';

    function testPlugin()
    {
        ob_start();
        print_r(\PMVC\plug($this->_plug));
        $output = ob_get_contents();
        ob_end_clean();
        $this->haveString($this->_plug,$output);
    }

    function testHexToRgb()
    {
        $c = \PMVC\plug($this->_plug);
        $expected = $c->getColor(255,255,255);
        $this->assertEquals($expected, $c->hexToRgb('#fff'));
        $this->assertEquals($expected, $c->hexToRgb('#ffffff'));
    } 

    function testGetPalette()
    {
        $c = \PMVC\plug($this->_plug);
        $palette = $c->getPalette(DEMO_PIC);
        $this->assertTrue(is_array($palette));
        $this->assertEquals(10,count($palette));
    }
}
