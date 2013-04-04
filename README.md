CRMx
===============
CRMx is a super-flexible micro-CRM system for personal, freelance and small businesses. It can be customized very quickly for Customer Relationship Management, Lead Management System, Project Management, To-Do List or any other usage due to its flexibility in customization and scalable code.

- <strong>RESTful API</strong>: Works through a RESTful API which allows third-party services and other software to interact neatly.
- <strong>Unlimited users & environments</strong>: Allows unlimited users to work in the same or different environments very flexibly (including a User Access Control system (UAC) to define permissions for each user and have maximum control).
- <strong>Simple setup</strong>: Similar to Sublime Text, all the config is done in <code>config.php</code> which keeps the overall code tiny and much easier to maintain and scale.
- <strong>Extremely scalable</strong>: CRMx is extremely small, with one PHP, one JS and one CSS files, with inline comments, you can see the code and start hacking it in 5 minutes. Oh, and you can also create CRMx plugins :)



Screenshots
---------------

### Table view

From here you have an overall view of your contacts:

![Table view](http://i.imgur.com/U6krA3U.png)

### Search as-you-type

Type in the search box to start filtering, results update dynamically as you type:

![Search as-you-type](http://i.imgur.com/5v3kgpQ.png)

### Smart filtering

CRMx detects your custom form field types and adds shortcut lists on the top navigation automatically:

![Smart filtering](http://i.imgur.com/H6Ur7IR.png)

### Person view

View a person details, edit them directly and also add timed comments:

![Person view](http://i.imgur.com/bAeyQHu.png)

### Smart links

Buttons appear next to the person fields to email, search Google or Skype-call in one click

![Smart links](http://i.imgur.com/W4Nj2LJ.png)


Technology
---------------

- Limonade PHP micro-framework (inc. <a href="https://gist.github.com/luckyshot/5098146">custom MySQL <i>lemon</i></a>)
- MySQL
- JavaScript / jQuery / JSON
- Twitter Bootstrap (and LESS)



Settings
---------------

There is no Settings menu or user accounts, all is done in PHP variables (like Sublime Text) in the <code>config.php</code> file, which makes the code app a lot smaller as well as easy to administer, maintain and scale.



Installation
---------------

Open <code>config.php</code> to modify the app settings:

- MySQL info and prefix
- Customize the <code>$form</code> array
- Add your <code>$users</code> and their permissions



User accounts
---------------

User accounts are created by adding them to the <code>$users</code> PHP array. These are the fields you can customize:

- <strong>name</strong> <small>(string)</small> Full name of the user
- <strong>pass</strong> <small>(string)</small> Add a very long random alphanumeric string of between 100 and 300 characters (the more the better, check <code>is_logged_in()</code> in the code for a generator)
- <strong>level</strong> <small>(string)</small> Add flags to allow users certain privileges
	- <strong>r</strong> <i>read</i>: useful when you want an external partner to submit contacts but not be able to access the CRM (i.e. external lead provider)
	- <strong>s</strong> <i>save</i>: create and update contacts
	- <strong>d</strong> <i>delete</i>: can delete contacts
	- <strong>c</strong> <i>comment</i>: can comment on contacts
- <strong>dbprefix</strong> <small>(string)</small> Many users can work in different environments on the same database by using a different table. To do this, just specify a different MySQL prefix here (i.e. <code>sales_</code>)
- <strong>sitename</strong> <small>(string)</small> You can customize the app title for each user


### Logging in

There is no login screen in CRMx. Users bookmark a long URL and click on it to login. You should specify a long and unique password (at least 50 characters) for each user and then send them the URL to bookmark, which looks like:

<code>http://crmx.com/login/thesuperlongpassword</code>



Environments
---------------

Environments allow users to work on separated CRMx (with their own contacts and form fields) while using the same app. Add that prefix to a user and another array in <code>$form</code>. Simple as that.




Form field types
---------------

It's very easy to customize CRMx to your own needs. You just need to modify the <code>$form</code> PHP array and the app will take care of the rest.


### Textbox

Just name and title are needed:

<pre>'name' => 'email',
'title' => 'Email address'</pre>


### Select dropdown

Specify <code>'type' => 'select'</code> and a list of elements:

<pre>'name' => 'color',
'title' => 'Favorite color',
'type' => 'select',
'list' => array( "Red", Green", "Blue" )</pre>


### Others formats

You can use other HTML5 form field types like: <code>password</code>, <code>hidden</code>, <code>color</code>, <code>date</code>, <code>datetime</code>, <code>datetime-local</code>, <code>email</code>, <code>month</code>, <code>number</code>, <code>range</code>, <code>search</code>, <code>tel</code>, <code>time</code>, <code>url</code> and <code>week</code>.

<pre>'name' => 'website',
'title' => 'Website URL',
'type' => 'url'</pre>


## Hidden

To skip a form field to show in the main table, set the <code>hidden</code> property to <code>1</code>. This is useful when you have a lot of fields.

<pre>'hidden' => 1,</pre>




REST API
---------------

### Home <code>/</code>

##### Request data (<code>GET</code>)

<i>(none)</i>

##### Response (<code>HTML</code>)

The home page in HTML format (including the default people and form JSON lists embedded to save server requests).



<hr>



### Login <code>/login/:pass</code>

##### Request data (GET)

- <code>pass</code> (string)

##### Response (<code>JSON</code>)

On success redirects to Home, on fail shows a message.



<hr>



### Search <code>/search/:q</code>

Searches people for that query and returns a JSON array.

##### Request data (<code>GET</code>)

- <code>q</code> (string)

##### Response <code>JSON</code>

<pre>[
  {
    "id":"46",
    "name":"Richard",
    "form":{
      "title":"CEO",
      // your defined form fields
    }
  },{
    "id":"37",
    "name":"Peter",
    "form":{
      "title":"Director",
      // your defined form fields
    }
  }
]</pre>



<hr>



### Load person <code>/get/:id</code>

You can pass an ID or a name, returns results for a single person (if more than one match returns the most recently modified).

##### Request data (<code>GET</code>)

- <code>id</code> (string)

##### Response (<code>JSON</code>)

<pre>{
  "id": "46",
  "name": "Richard",
  "form": {
    "title": "CEO",
    // your defined form fields
  },
  "comments":[
    {
      "user": "Xavi Esteve",
      "date": "2013-03-24T16:03:19+00:00",
      "text": "..."
    }
  ],
  "created": "1364140289",
  "updated": "1364140289"
}</pre>



<hr>



### Save person <code>/save</code>

##### Request data (<code>POST</code>)

- <code>id</code> (string)

##### Response (<code>JSON</code>)

<pre>[
  {
    "status": "success" OR "error",
    "message": "Contact saved successfully."
}
]</pre>



<hr>



### Delete person <code>/delete</code>

##### Request data (<code>DELETE</code>)

- <code>id</code> (string)

##### Response (<code>JSON</code>)

<pre>[
  {
    "status": "success" OR "error",
    "message": "Contact deleted successfully."
}
]</pre>



<hr>



### Add comment <code>/comment</code>

##### Request data (<code>POST</code>)

- <code>id</code> (integer)
- <code>comment</code> (string)

##### Response (<code>JSON</code>)

<pre>[
  {
    "status": "success" OR "error",
    "message": "Comment added."
}
]</pre>



<hr>



### Delete comment <code>/comment/:id</code>

##### Request data (<code>DELETE</code>)

- <code>id</code> (integer)

##### Response (<code>JSON</code>)

<pre>[
  {
    "status": "success" OR "error",
    "message": "Comment deleted."
}
]</pre>






Plugins
--------------

With plugins you can add extra functionality to CRMx without needing to modify the core files. Creating plugins is extremely easy and you can run PHP, JavaScript and/or CSS code. To create a plugin, add a new folder to the <code>plugins</code> folder and files, all with your plugin name:

<pre>/plugins/salesforce
	salesforce.php
	salesforce.js
	salesforce.css</pre>

All files are optional, if you want to create a theme then a single CSS file should be enough. If you want to have a file that doesn't run automatically then name it differently than the plugin name.

The last step is to add the plugin name to the <code>$plugins</code> array in <code>config.php</code>.



Multi-language
---------------

In the <code>lang</code> folder, create a new language file (use <a href="http://en.wikipedia.org/wiki/List_of_ISO_639-1_codes" target="_blank" rel="nofollow">ISO 639-1 codes</a>) or use an existing one. 

Then, add <code>'lang' => 'es-es',</code> in the <strong>user's configuration</strong>.

Alternatively, you can change <code>LANG_DEFAULT</code> so everyone will have the same language.

Having different languages is not only useful to change the language of CRMx but to customize the app further. For example, if you use CRMx as a Project Plan system you can rename 'Name' to 'Project' or 'Save contact' to 'Save project'.



MySQL table details
---------------

### <code>people</code> table

- <strong>id</strong> <small>(int20, primary, autoincrement)</small>
- <strong>name</strong> <small>(string255, mandatory)</small>
- <strong>form</strong> <small>(text, json)</small>
- <strong>comments</strong> <small>(text, json)</small>
- <strong>created</strong> <small>(int11)</small>
- <strong>updated</strong> <small>(int11)</small>








Changelog
----------------

### 4 April 2013

- Fixed sorting Titles (thanks <a href="https://github.com/soomiq" rel="nofollow">Soomiq</a>)
- Fixed Language files
- Added sprite images


### 1 April 2013
- Multilanguage
- Plugins
- Code clean up and improvements
- Favicon


### 29 March 2013

- Generate MySQL tables automatically
- Multiword search
- Sort by column
- Delete comments
- Code optimization
- Code documentation and inline comments


### 28 March 2013

- CRMx plugins to add extra functionality (canned responses, SalesForce integration, etc.)
- Table view instead of Sidebar
- Redesigned top nav
- Search also searches comments now
- Added icons and buttons
- Form is now two-column instead of one
- Smart links in detail view
- Improved docs, added screenshots
- Many more improvements and small tweaks
- Fixed bugs with notification message
- Other bugs fixed
- Reorganized all files
- Minified all JS into one file
- jQuery to use latest instead of 1.8.6
- Minified CSS into two files
- Responsive improvements
- MIT licensed



To Do
----------------
- Use same date format along MySQL
- Smooth scrolling anchors up/down page
- Write tests


License
----------------

CRMx has been created by Xavi Esteve and is licensed under a MIT License.

Copyright &copy; 2013 Xavi Esteve

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.


Credits
---------------

Author: <strong><a href="http://xaviesteve.com/" target="_blank">Xavi Esteve</a></strong> (<a href="http://twitter.com/xaviesteve" target="_blank" rel="nofollow">@xaviesteve</a>)

- Icons by <a href="http://glyphicons.com/" target="_blank" rel="nofollow">Glyphicons</a> (attribution)
- <a href="http://twitter.github.com/bootstrap/" target="_blank" rel="nofollow">Twitter Bootstrap</a> by Twitter, Inc (Apache license)
- <a href="http://limonade-php.github.com/" target="_blank" rel="nofollow">Limonade PHP micro framework</a> by Fabrice Luraine (MIT license)
- <a href="http://easydate.parshap.com/" target="_blank" rel="nofollow">EasyDate</a> by Parsha Pourkhomami (MIT license)
- <a href="https://github.com/bryanwoods/autolink-js" target="_blank" rel="nofollow">AutoLink</a> by Bryan Woods (open sourced)

