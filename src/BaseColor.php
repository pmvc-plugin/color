<?php
namespace PMVC\PlugIn\color;

class BaseColor
{
    const COLOR_ROUNDING_COEFF = 0x33;
    public $r;
    public $g;
    public $b;
    public $a;

    function __construct($r = null, $g = null, $b = null, $a = null)
    {
        $this->r = $r ? $r : 0;
        $this->g = $g ? $g : 0;
        $this->b = $b ? $b : 0;
        $this->a = $a ? $a : 0;
    }

    function getClone()
    {
        return clone $this;
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
        $this->r = round($this->r * $alpha + $other['r']);
        $this->g = round($this->g * $alpha + $other['g']);
        $this->b = round($this->b * $alpha + $other['b']);
        return $this;
    }

    function toHex()
    {
        $colorstr = '';
        $colorstr .= str_pad(dechex($this->r), 2, 0, STR_PAD_LEFT);
        $colorstr .= str_pad(dechex($this->g), 2, 0, STR_PAD_LEFT);
        $colorstr .= str_pad(dechex($this->b), 2, 0, STR_PAD_LEFT);
        return $colorstr;
    }

    function toArray()
    {
        return [
            'r' => $this->r,
            'g' => $this->g,
            'b' => $this->b,
        ];
    }

    protected function toString()
    {
        return join(',', $this->toArray());
    }

    public function __toString()
    {
        return $this->toString();
    }

    function toRound()
    {
        $div = self::COLOR_ROUNDING_COEFF;
        $this->r = round(round($this->r / $div) * $div);
        $this->g = round(round($this->g / $div) * $div);
        $this->b = round(round($this->b / $div) * $div);
        return $this;
    }

    /**
     * @param resource $image gd image resource http://php.net/manual/en/function.imagecreatetruecolor.php
     * @see http://php.net/manual/en/function.imagecolorallocate.php
     * @see https://www.php.net/manual/en/function.imagecolorallocatealpha.php
     */
    function toGd($image, $toAlpha = null)
    {
        $oGd = \PMVC\plug('image')->getGd($image);
        if ($toAlpha) {
            return imagecolorallocatealpha(
                $oGd,
                $this->r,
                $this->g,
                $this->b,
                $this->a
            );
        } else {
            return imagecolorallocate($oGd, $this->r, $this->g, $this->b);
        }
    }
}
