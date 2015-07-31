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

    function getClone()
    {
        return clone($this);
    }

    function decrease(BaseColor $other)
    {
        $this->r -= $other->r;
        $this->g -= $other->g;
        $this->b -= $other->b;
        return $this;
    }

    function setAlpha(BaseColor $other, $alpha)
    {
        $this->decrease($other);
        $other = $other->toArray();
        $this->r = $this->r * $alpha + $other['r'];
        $this->g = $this->g * $alpha + $other['g'];
        $this->b = $this->b * $alpha + $other['b'];
    }

    function toHex()
    {
        $colorstr='';
        $colorstr.=str_pad(dechex($this->r), 2, 0, STR_PAD_LEFT);
        $colorstr.=str_pad(dechex($this->g), 2, 0, STR_PAD_LEFT);
        $colorstr.=str_pad(dechex($this->b), 2, 0, STR_PAD_LEFT);
        return $colorstr;
    }

    function toArray()
    {
        return array(
            'r'=>$this->r
            ,'g'=>$this->g
            ,'b'=>$this->b
        );
    }

    /**
     * @param resource $image gd image resource http://php.net/manual/en/function.imagecreatetruecolor.php
     * @see http://php.net/manual/en/function.imagecolorallocate.php
     */
    function toGd($image)
    {
        return imagecolorallocate(
            $image,
            $this->r,
            $this->g,
            $this->b
        ); 
    }
}
