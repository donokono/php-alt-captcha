<?php
/**
 * test.php
 *
 * @author Bob Scott <bob@zyzo.com>
 * @date   3/28/2017
 */

session_start();
$debugInfo = '';

// Show some debugging info if we have user input.
if (isset($_POST['submit_form'])) {
  $matches = $_SESSION['confirmation_code'] == $_POST['confirmation_input'] ? 'Yes' : 'No';
  $debugInfo .= '_POST: ' . print_r($_POST, true) . "\n\n";
  $debugInfo .= '_SESSION: ' . print_r($_SESSION, true) . "\n\n";
  $debugInfo .= 'Match?: ' . print_r($matches, true) . "\n\n";
}

// make confirmation string
include_once('confirmationImage.php');
$cm = new confirmationImage;
$cm->makeImage();
$_SESSION['confirmation_code'] = $cm->photo_number;
$debugInfo .= 'confirmationImage: ' . print_r($cm, true) . "\n\n";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Confirmation Image Test</title>
  <style>
    body {
      color:#666;
      font-family:Verdana;
    }
    .debug-info {
      padding:10px;
      font-size:11px;
      background-color:#eee;
      border:solid #666 1px;
      margin-bottom:20px;
    }
    .debug-info code {
      white-space:pre;
      color:#999;
      font-family:monospace;
    }
  </style>
</head>
<body>
<div class="debug-info">
  <code><?php echo  $debugInfo; ?></code>
</div>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
  <p><img src="<?php echo $cm->image; ?>" /></p>
  <p>
    <label>
      Please enter the number next to the photo of the <?php echo $cm->photo_name; ?>
      <input type="text" name="confirmation_input" />
    </label>
  </p>
  <p><input type="submit" name="submit_form" /> </p>
</form>
</body>
</html>


