Notes:
------
* You need restart the server for player to recognize new song(s).
* PHP Safe Mode must be off to upload through block.
* Uploading through block means that upload_limit in php.ini in enforced. Current limit will display on block.
* You can manually add songs but putting them in '../blocks/radio_listener/media'. You need to add it to "playlist.txt" as well while following the format. (ex. song1,song2,song3) You still need to restart the server.

This has been tested on 2.7 and 2.7.1. I have not tested it on any older builds.

A credits file for the sample songs used under the Creative Commons license can be found in the media folder.

=============
*!*NOTICE*!*
=============
Songs must be removed MANUALLY from the media folder. There is no function to do this via the plugin.
SONGS MUST BE REMOVED FROM THE 'PLAYLIST.TXT' FILE!! If you remove a song from the folder, but do
not take it out of the playlist, the player will still thinks it's there and attempt to play it.
Additionally, if you want to take a song off the playlist but do not want to delete it, you can delete
it from 'playlist.txt' and the radio will stop playing it after you reset the server. I don't know why
you need to restart the whole server rather than clearing the cache of the javascript. You might need
to do both. I always did just to be sure. I actually spent a lot of time pulling my hair out because I couldn't figure out why my javascript wasn't working during testing. Turns out that I was forgetting to clear the cache and was just refreshing the page. After that, sometimes I would clear the cache two or three times just to be safe. I have trouble remembering things. 