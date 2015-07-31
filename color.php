<?php
namespace PMVC\PlugIn\color;

\PMVC\l(__DIR__.'/src/BaseColor.php');

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\color';

class color extends \PMVC\PlugIn
{
    public function getPalette($file)
    {
        \PMVC\l(__DIR__.'/src/ColorPalette.php');
        return ColorPalette::GenerateFromLocalImage($file);
    }
}
