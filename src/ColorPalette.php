<?php
namespace PMVC\PlugIn\color;

use PMVC\PlugIn\image\ImageFile;
use PMVC\PlugIn\image\ImageSize;
use PMVC\PlugIn\image\Coord2D;

/**
 * This class can be used to get the most common colors in an image, or to generate
 * a color palette from a set of images.  It handles a simple local cache of images.
 * @see Copied and modified from http://www.codediesel.com/php/generating-color-palette-from-aimage/
 */
class ColorPalette {

  /**
   * It is important to cluster the colors into groups, otherwise you won't find any duplicates in
   * photos.  Without rounding you would end up with a lot of colors that are ALMOST the same.
   * Using 0x33 here reduces this to the "web safe" color palette.
   */
  const COLOR_ROUNDING_COEFF = 0x33;

  /**
   * Returns the colors of the image in an array, ordered in descending order, where
   * the keys are the colors, and the values are the count of the color.
   * @param $filePath   the path to the local image file
   * @return an array keyed by hex color value, mapping to the frequency of use in the images
   */
  static public function GenerateFromLocalImage(ImageFile $file) {
    $pImage = \PMVC\plug('image');

    // resize the image for a reasonable amount of colors
    $previewSize = new ImageSize(150, 150);
    $srcSize = $file->getSize();
    $scale=1;
    if ($srcSize->w>0){
      $scale = min($previewSize->w/$srcSize->w, $previewSize->h/$srcSize->h);
    }
    if ($scale < 1) {
      $destSize = new ImageSize(
            floor($scale*$srcSize->w),
            floor($scale*$srcSize->h)
      );
    } else {
      $destSize = new ImageSize(
            $srcSize->w,
            $srcSize->h
      );
    }
    $image_resized = $pImage->create($destSize);
    $image_orig = $pImage->create($file);
    //WE NEED NEAREST NEIGHBOR RESIZING, BECAUSE IT DOESN'T ALTER THE COLORS
    imagecopyresampled(
        $image_resized,
        $image_orig,
        0,
        0,
        0,
        0,
        $destSize->w,
        $destSize->h,
        $srcSize->w,
        $srcSize->h);

    // walk the image counting colors
    $hexarray = [];
    $pImage->process(
        $destSize,
        [$image_resized],
        function($point, $im) use (&$hexarray){
            $index = imagecolorat($im,$point->x,$point->y);
            $Colors = imagecolorsforindex($im,$index);
            $hexarray[]=(new BaseColor($Colors['red'],$Colors['green'],$Colors['blue']))->toHex();
        }
    );
    $hexarray = array_count_values($hexarray);
    natsort($hexarray);
    $hexarray = array_slice($hexarray,-10,10);
    $hexarray = array_reverse($hexarray,true);
    return $hexarray;
  }

}
