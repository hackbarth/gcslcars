# gcslcars
This program is made to read files made with GCS.

GCS - GURPS Character Sheet - is a Open source Java Program that makes Charater Sheets for the tabletop GURPS RPG system. That Program saves characters as XML files.

GCSLCARS is a program that can read charater files made in GCS and display them as a web page, styled to look like a Star Trek LCARS display. The purpose of that is to provide for the players easy to read charater files that have a design in the Star Trek motif for a Star Trek RPG game. The players con print these pages or they can access them on portable devices, like a cellphone or tablet, and use them as props in the game.


How to use:
Host the program in a web server that supports PHP
Put your character file genereted with GCS in the gcs folder.
Put a character portrait JPG file with a square aspect ratio with the same name as the character file in the img folder
Access the address of the web page with the parameter 'char' equals to the file name for the gcs file.
example:
https://localhost/gcsreader?char=?char=Shi%20MRia
