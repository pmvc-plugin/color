<?php

namespace PMVC\PlugIn\color;

use PMVC\PlugIn\image\ImageFile;

\PMVC\l(__DIR__ . '/src/BaseColor');

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__ . '\color';

class color extends \PMVC\PlugIn
{
    public function getPalette($file)
    {
        \PMVC\l(__DIR__ . '/src/ColorPalette.php');
        $image = new ImageFile($file);
        return ColorPalette::GenerateFromLocalImage($image);
    }

    public function getColor($r = null, $g = null, $b = null, $a = null)
    {
        return new BaseColor($r, $g, $b, $a);
    }

    public function fill($oGd, BaseColor $bgColor)
    {
        $pImg = \PMVC\plug('image');
        imagefill($pImg->getGd($oGd), 0, 0, $bgColor->toGd($oGd));
    }

    public function hexToRgb($hex)
    {
        $hex = str_replace('#', '', $hex);
        switch (strlen($hex)) {
            case 3:
                $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
                $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
                $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
                break;
            case 6:
                $r = hexdec(substr($hex, 0, 2));
                $g = hexdec(substr($hex, 2, 2));
                $b = hexdec(substr($hex, 4, 2));
                break;
            default:
                return !trigger_error('[HexToRgb] color length not correct');
                break;
        }
        return new BaseColor($r, $g, $b);
    }
}
