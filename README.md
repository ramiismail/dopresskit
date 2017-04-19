dopresskit
==========

presskit() - spend time making games, not press.


About this fork
---------------
I noticed when I went to use presskit() that, while it worked out of the box, there were a few minor issues, such as a dead "projects" link showing up on each individual project.  Looking into it a bit further, I saw that there were 21 outstanding pull requests, and no activity for two years.  My e-mail to Rami was met with an autoresponder indicating a very busy person, which I'm glad about--that means the goal of letting game devs work on their games was being realized!

Meanwhile, for presskit() users, I thought it would be nice if there were a way to get some of these pull requests integrated, and also update directly from GitHub when a release was put out, as [TheSeg recommended](https://github.com/ramiismail/dopresskit/issues/5#issuecomment-72758047).  I also flattened and deduplicated the directory structure, because I noticed even the upstream master had some differences between the root `style.css` and `install.php` and their `/archive` counterparts, likewise with `_data.xml` and its `/_template` counterpart.

If you want to integrate more PRs from upstream, or generally make your own fork of this fork that can update itself from GitHub, you need only change [this line](https://github.com/codingthat/dopresskit/blob/master/install.php#L13) to point to your fork.  The updater will look for the latest tagged release rather than the latest commit, so be sure to tag releases to make your changes more readily available.

If/when Rami wants to take the reins again, at least the structure is there.  Meanwhile, it's maybe a bit easier for all of us to share our improvements with each other.  :)


How to upgrade your current install to this fork
------------------------------------------------
Just save `install.php` somewhere, and upload it to your server's press directory, wherever you originally put it when you installed presskit().  Access that directory from your web browser, and it should upgrade, and then tell you to delete/move `install.php` afterwards.  That's all there is to it!

Future upgrades can be done in the same fashion.


Simple. Fast. Free.
==========
Developers & press both have the same goal: to bring great games to as many people as possible - after all, a good game is worth nothing if no-one plays it. For the press, finding out about a game but not having access to information & media for the game means that they can't write about it. Of course, developers want to spend their valuable time making games instead of press pages.

presskit() (pronounced 'do presskit') is the solution. Free for everyone, open and easy-to-use for both developers & press. Developers only have to spend an hour or so creating well-laid out press pages with everything the press needs to write to their hearts desire. Everybody wins.


What is presskit()?
==========
Beautiful, optimized and efficient press pages in 30-60 minutes.
Usable by anyone who knows what FTP, text editing & image editing means.
Fast & painless 'Single File Upload'-installation.
Created using feedback of prominent journalists & indie developers.
Optional, seamless integration with Promoter & Google Analytics
What does beta mean?

presskit() is currently in beta, which means that all functionality is in there, but not everything has been tested. It also means that I officially take no responsibility for your presskit()-installation whatsoever. While I've tested it extensively and presskit() is incapable of damaging, deleting or modifying anything above its root installation directory, it might suddenly stop working, have some rough patches or not do exactly what you want. That's part of the deal.


What is new in presskit()?
==========
presskit() is currently in beta, which means new functions get added every now and then. Since its launch in early May, a lot of functions have been added. The manual has info on anything listed here that is not explained. These functions have been added recently:

Easily monitor who mentions you in the press with Promoter and embed awards and reviews that Promoter finds with a single click.
Integrate easily with Google Analytics to keep track of who, when and from where visits to your presskit() are made.
Enable or disable the press request section of a project by adding a <can-request-press-copy> tag set to FALSE.
You have a specific wish, idea or feedback? Get in touch at rami@vlambeer.com or at @tha_rami!


Why is presskit() free?
==========
The goal of creating presskit() was to save myself and the people in the press that want to write about Vlambeer as much time as possible.

As development of presskit() furthered, an increasing amount of fellow independent game creators asked about how easy it was to implement. This convinced me that this little project could make life easier for a lot more people than just myself.

presskit(), in the spirit of independent developers helping eachother out when it comes to making games or doing business, is completely free for anyone to use.


presskit() was only possible thanks to these fine folks!
==========

presskit() was created in just over a week by Rami Ismail of Dutch independent game studio Vlambeer. Rami does the business & development at Vlambeer and found himself looking for an efficient solution to press kits. presskit() was the result, but it wouldn't have been if it weren't for the following fine folks:

* Andreas Zecher - Made by Pixelate - for the original inspiration that made me create this kit.
* Jan Willem Nijman - Vlambeer - for starting Vlambeer with me, which eventually led to this thing.
* Russ Frushtick - Polygon - for general feedback from a press-person point-of-view.
* Martin Jonasson - grapefrukt - for challenging me to a race to see who could write the most efficient install script.
* Joram Wolters - JoramWolters.com - for his always sharp critique on game & web design and functionality.
* Jan Pieter van Seventer - Dutch Game Garden - for support & feedback.
* Adriaan de Jongh - gameovenstudios.com - for distractions and meaningful Skype-conversations during presskit()s development.
* Philip Tibitoski - octodadgame.com - for inspiring me to make this publically available.

The indie community at large for being amazing, open-minded, supportive, creative and interesting people.
Friends, family & girlfriend for allowing & supporting me to do what I love to do, to pursue my dreams and to make games.
