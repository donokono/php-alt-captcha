<?php

/**
 * confirmationImage.php
 *
 * @author Bob Scott <bob@zyzo.com>
 * @date   3/28/2017
 */

/**
 * Class confirmationImage
 */
class confirmationImage {

  /**
   * confirmationImage constructor.
   */
  function __construct() {
    $this->photo_dir = './things/'; // with trailing slash - directory where the images are stored
    $this->text_angle = 25;
    $this->text_pos_x = 56;
    $this->text_pos_y = 96;
    $this->text_font_size = 20;
    $this->random_font = './fonts/arialbi.ttf'; // True Type font to use
    $this->photo_name = null;
    $this->photo_number = null;
    $this->image = null;
  }

  /**
   * makeImage
   * Generate a composite confirmation image based on randomly selected elements.
   * @return bool true
   */
  public function makeImage() {

    $randomNumbers = array();
    $photos = array();
    $photoNames = array();
    $im = array();

    // Get all available photos
    if ($handle = opendir($this->photo_dir)) {
      while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != ".." && !strstr($file,'php')) {
          $photos[] = $this->photo_dir . $file;
        }
      }
      closedir($handle);
    }

    // Randomize photos
    shuffle($photos);

    // Get the first 9 random images.
    // Create a 3 digit number for each of the images
    // also derive the name of the image from the file name

    for ($i = 1 ; $i <= 9 ; $i++) {
      $im[$i] = @imagecreatefrompng($photos[$i]);
      $fontColor[$i] = imagecolorallocate($im[$i], rand(188,255), rand(188,255), rand(188,255));
      $fontColorB[$i] = imagecolorallocate($im[$i], rand(0,120), rand(0,120), rand(0,120));
      $rNum = rand(100,999);
      // never have duplicate random numbers
      while (!in_array($rNum, $randomNumbers)) {
        $randomNumbers[$i] = $rNum;
        $rNum = rand(100,999);
      }
      // get photo name from file name
      $photoNames[$i] = strtoupper(str_replace('.png', '', str_replace($this->photo_dir, '', $photos[$i])));
      // put numbers on each photo
      imagettftext($im[$i], $this->text_font_size, $this->text_angle, $this->text_pos_x-1, $this->text_pos_y-1, $fontColor[$i], $this->random_font, $randomNumbers[$i]);
      imagettftext($im[$i], $this->text_font_size, $this->text_angle, $this->text_pos_x+1, $this->text_pos_y+1, $fontColor[$i], $this->random_font, $randomNumbers[$i]);
      imagettftext($im[$i], $this->text_font_size, $this->text_angle, $this->text_pos_x-2, $this->text_pos_y-2, $fontColor[$i], $this->random_font, $randomNumbers[$i]);
      imagettftext($im[$i], $this->text_font_size, $this->text_angle, $this->text_pos_x+2, $this->text_pos_y+2, $fontColor[$i], $this->random_font, $randomNumbers[$i]);
      imagettftext($im[$i], $this->text_font_size, $this->text_angle, $this->text_pos_x, $this->text_pos_y, $fontColorB[$i], $this->random_font, $randomNumbers[$i]);
    }

    // Make final composite image
    $imf = imagecreatetruecolor(300, 300);
    $cc = 1;
    for ($x = 0 ; $x < 300 ; $x += 100) {
      for ($y = 0 ; $y < 300 ; $y += 100) {
        imagecopy ($imf, $im[$cc], $x, $y, 0, 0, 100, 100);
        $cc++;
      }
    }

    // What number / photo combination shall we use?
    $crn = rand(1,9);
    $this->photo_name = $photoNames[$crn];
    $this->photo_number = $randomNumbers[$crn];

    // Enable output buffering
    ob_start();

    // Capture the output
    imagepng($imf);
    $imgData = ob_get_contents();

    // Clear the output buffer
    ob_end_clean();

    $this->image = 'data:image/png;base64,'.base64_encode($imgData);

    // Free up memory.
    imagedestroy($imf);
    for ($i = 1 ; $i <= 9 ; $i++) {
      imagedestroy($im[$i]);
    }
    return true;
  }
}
