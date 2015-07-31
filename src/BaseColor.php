<?php
namespace PMVC\PlugIn\color;

class BaseColor
{
    private $r;
    private $g;
    private $b;

    function __construct($r=null, $g=null, $b=null)
    {
       $this->r = $r; 
       $this->g = $g;
       $this->b = $b;
    }

    function toHex()
    {
        $colorstr='';
        $colorstr.=str_pad(dechex($this->r), 2, 0, STR_PAD_LEFT);
        $colorstr.=str_pad(dechex($this->g), 2, 0, STR_PAD_LEFT);
        $colorstr.=str_pad(dechex($this->b), 2, 0, STR_PAD_LEFT);
        return $colorstr;
    }

}
