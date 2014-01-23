Movie Commit
============================
[![Build Status](https://travis-ci.org/davidstanley01/MovieCommit.png?branch=master)](https://travis-ci.org/davidstanley01/MovieCommit)
This is a simple website to give you a random movie quote, suitable for git commit message.

There are two routes - / and /clean.

The default route gives you a nice, pretty UI with a movie quote.  The `/clean` route will give you just the quote - nothing else.

Contributing
============

I need help adding movies and quotes.

If you would like to help out, fork this repo.  Edit the `src/config/config.php` file by adding movie titles to the 'movies' array key. Then, create a text file (use .txt extension) within the `src/MovieCommit/data` directory. The name of the file and the name used in the config array should be the same (no spaces, etc).

The first line should be the full title of the move. Put each quote on a separate line after that.

Once you've added your stuff, send a PR and I'll merge it.