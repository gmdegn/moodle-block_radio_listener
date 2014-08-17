<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
 
/**
 * The upload file.
 *
 * This is the php file for uploading music to the server.
 * you will probably want to change the server upload limit if
 * you plan on using this, as 2M isn't really sufficient. This will
 * automatically write the song's title to the playlist. Only admins
 * have access to this function via the main plugin php file, and
 * it's highly recommended that it stays that way.
 *
 * @package    block_radio_listener
 * @category   block
 * @copyright  2014 Gary McKnight
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
 //This gets the path to the config.php. There's probably a better way to do this,
 //but I couldn't find it.
$path = dirname(__file__);
$path = str_replace("\\blocks\\radio_listener","\\",(string)$path);
$path = $path."config.php";
include_once($path);
Global $CFG;
require_once($CFG->libdir.'/filelib.php');

//All music and the playlist file gets dumped in here.
//Interestingly enough I thought that this url would need to
//follow the same 'wwwroot.' file path magic that all the
//other urls did but apparently it goes right into the 
// media folder on the same directoy as this php file.
// Shows what I know.
$storage = 'media/';

//Only wav, ogg and mp3 files are allowed. That's because
//HTML5 audio can only play those formats. I wouldn't 
//recommend adding any formats to this, unless HTML5
//magically starts supporting new formats.
$allowedExts = array("wav", "ogg", "mp3");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);

//This will display the name, size and type of the file.
//It will also tell you if there's an error, if the file already exists
//and if the upload was successful or not.
if (in_array($extension, $allowedExts)) {
  if ($_FILES["file"]["error"] > 0) {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
  } else {
    echo "Upload: " . $_FILES["file"]["name"] . "<br>";
    echo "Type: " . $_FILES["file"]["type"] . "<br>";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
    if (file_exists($storage . $_FILES["file"]["name"])) {
      echo $_FILES["file"]["name"] . " already exists. ";
    } else {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      $storage . $_FILES["file"]["name"]);
      echo "Upload Successful!";
	  file_put_contents($storage."playlist.txt", ",".$_FILES["file"]["name"], FILE_APPEND);
    }
  }
} else {
  echo "Invalid file";
}