todotxt
===========

TODO.TXT Web Manager is a simple web interface which will help you to control your tasks in a plain text. It is based on an idea described on [Todo.txt](http://todotxt.com) project webpage.

![](https://github.com/cpiekacz/todotxt/raw/master/todotxt.png)

Why would you like to track all your tasks in simple text file? Read [Why plain text?](http://todotxt.com/whytxt.php) article to find out. It's simple, clean, fast and really usefull.

Installation
------------

All you need to set it up is download these three files:

* **parse.php** which sorts your tasks and reads/writes them to a todo file
* **index.html** which is a web interface which uses AJAX to talk to parse.php
* **todo.txt** which is a simple text file with all your tasks written in it.

Just remember to change permitions to **todo.txt** file to **read/write** for user/group/other (depends on your configuration) to allow web server to modify it.

Usage
-----

After you enter web page for the first time, you'll see some default tasks. You can change them by clicking anywhere on the screen, and replacing text with your own. If you want to save it just click on the toolbar at the top of the screen or press the enter key (so in fact todos are saved automaticaly after adding every new line).

You can sort your tasks by priority [(A), (B), ...], context [@home, @work, ...] or project [p:project1, p:project2, ...]. If you have any suggestions for a new version just send me an e-mail.

Example
-------

If you want to check how this script works, just go to the [example page](http://redfish.pl/programy/todotxt/example/). Any changes made to the tasks list will be saved in a cookie for 1 hour.

Contact
-------

* cpiekacz@gmail.com
* https://twitter.com/cezex

Licence
-------

Gmail Snooze is available under the MIT license.

Copyright © 2013 Cezary Piekacz

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.