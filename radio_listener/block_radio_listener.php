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
 * The main Radio_Listener file file.
 *
 * @package    block_radio_listener
 * @category   block
 * @copyright  2014 Gary McKnight
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_radio_listener extends block_base {
    public function init() {
        $this->title = get_string('radio_listener', 'block_radio_listener');
		define('AJAX_SCRIPT', true);
    }
	
    public function get_content() {
		global $PAGE, $CFG, $DB;
		
		require_once($CFG->libdir.'/filelib.php');
		
		//get required javascript libraries
		$this->page->requires->js('/blocks/radio_listener/js/radio.js');
		$this->page->requires->js('/blocks/radio_listener/js/jquery-1.11.1.min.js');
		$this->page->requires->jquery();

		//links for images, the php files used for uploading and a variable to hold the maximum upload limit
		$leftA = $CFG->wwwroot.'/blocks/radio_listener/img/lar.png';
		$rightA = $CFG->wwwroot.'/blocks/radio_listener/img/far.png';
		$upload = $CFG->wwwroot.'/blocks/radio_listener/upload.php';
		$maxUp = ini_get("upload_max_filesize");

        if ($this->content  !== null) {
            return $this->content;
        }

        $this->content = new stdClass;
        $this->content->text = '';
        $this->content->footer = '';
				
		//If you are the admin, you get a button fo enable the 'upload a song' form. Registered users get a regular radio. Guests get nothing.
		if(is_siteadmin()){
			$radio = "<body onload='startUp()'><div><center>ADMIN</center></div>
					<div id='rdo'><audio  id='audio' controls autoplay src=''></audio><br>
					<h4><input id='bttn' type='image' src=$leftA value=&larr; onclick='prevSong();'/>
					<input type='checkbox' id='loop'>Repeat
					<input id='bttn' type='image' src=$rightA value=&larr; onclick='nextSong();'/></h4></div>
					<span id='uploader' style='display: none;'><center><form action=$upload method='post' enctype='multipart/form-data'>
					<label for='file'>Upload Song (Max Size $maxUp):</label><input type='file' name='file' id='file'><br>
					<input type='submit' name='submit' value='Submit'></form></center></span>
					<input id='btn' type='button' value=&#8657; onclick='showUpload(this);'/></body>";
		}
		else if (isloggedin()) {
			$radio = "<body onload='startUp()'>
					<div id='rdo'><audio  id='audio' controls autoplay src=''></audio><br>
					<h4><input id='bttn' type='image' src=$leftA value=&larr; onclick='prevSong();'/>
					<input type='checkbox' id='loop'>Repeat
					<input id='bttn' type='image' src=$rightA value=&larr; onclick='nextSong();'/></h4></div></body>";
		}
		else if ($reqlog){
			$radio = "Log in to listen!";
		}
        
		//This changes the title to display the current song on the right.
		$this->title = "RADIO LISTENER <font size='4'>&#10147;</font><u id='nplin'></meta></u>";
        $this->content->text = $radio;

        return $this->content;
    }
}