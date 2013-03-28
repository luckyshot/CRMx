CRMx
===============
<p style="font-size:133%;">
	CRMx is a super-flexible micro-CRM system for personal, freelance and small businesses. It can be customized very quickly for Customer Relationship Management, Lead Management System, Project Management, To-Do List or any other usage due to its flexibility in customization and scalable code. </p>

CRMx allows unlimited users to work in the same or different environments very flexibly. CRMx works through a RESTful API which allows third-party services and other software to interact neatly. CRMx also has a User Access Control system (UAC) to define permissions for each user and have maximum control over the organization.


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



Technology
---------------

- Limonade PHP micro-framework (inc. <a href="https://gist.github.com/luckyshot/5098146">custom MySQL <i>lemon</i></a>)
- MySQL
- JavaScript / jQuery / JSON
- Twitter Bootstrap (and LESS)



Installation
---------------

1. Open <code>config.php</code> and modify the app settings, MySQL info and prefix, customize the <code>$form</code> array and add your <code>$users</code> and their permissions
2. Open <code>dump.sql</code>, add your <code>MYSQL_PREFIX</code> (if any) and then import into database


Settings
---------------

There is no Settings menu or user accounts, all is done in PHP variables (like Sublime Text) in the <code>config.php</code> file, which makes the code app a lot smaller as well as easy to administer, maintain and scale.


User accounts
---------------

User accounts are created by adding them to the <code>$users</code> PHP array. These are the fields you can customize:

- <strong>name</strong> <small>(string)</small> Full name of the user
- <strong>pass</strong> <small>(string)</small> Add a very long random alphanumeric string of between 100 and 300 characters (the more the better, check <code>is_logged_in()</code> in the code for a generator)
- <strong>level</strong> <small>(string)</small> Add flags to allow users certain privileges
	- <strong>r</strong> <i>read</i>: useful when you want an external partner to submit contacts but not be able to read it (i.e. external lead provider)
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

Environments allow users to work on separated CRMx (with their own contacts and form fields) while using the same app. To enable more environments, import the table in <code>dump.sql</code> with a new prefix and add that prefix to a user. Then add another array in <code>$form</code>. Simple as that.




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

<table>
	<thead>
		<tr>
			<th>URI</th>
			<th>Request</th>
			<th>Response</th>
			<th>Output</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>/</td>
			<td>GET</td>
			<td>HTML</td>
			<td>The home page in HTML format (including the default people and form JSON lists embedded to save server requests).</td>
		</tr>
		<tr>
			<td>/login/:pass</td>
			<td>GET<br><pre>pass (string)</pre></td>
			<td>(Redirect to <code>/</code>)</td>
			<td>On success redirects to <code>/</code>, on fail shows a message</td>
		</tr>
		<tr>
			<td>/search/:q</td>
			<td>GET<br><pre>q (string)</pre></td>
			<td>JSON<br><pre>[
  {
    "id":"46",
    "name":"Richard",
    "form":{
      "title":"CEO",
      "group":"London",
      "type":"Provider",
      "email":"",
      // ...
    }
  },{
    "id":"37",
    "name":"Peter",
    "form":{
      "title":"Director",
      "group":"London",
      "type":"-",
      "email":"",
      // ...
    }
  }
]</pre></td>
			<td>Searches people for that query and returns a JSON array.</td>
		</tr>
		<tr>
			<td>/get/:id</td>
			<td>GET<br><pre>id (string)</pre></td>
			<td>JSON<br><pre>{
  "id":"46",
  "name":"Richard",
  "form":{
    "title":"CEO",
    "group":"London",
    "type":"Provider",
    "email":"",
    // ...
  },
  "comments":[
    {
      "user":"Xavi Esteve",
      "date":"2013-03-24T16:03:19+00:00",
      "text":"..."
    }
  ],
  "created":"1364140289",
  "updated":"1364140289"
}</pre></td>
			<td>You can pass an ID or a name, returns results.</td>
		</tr>
		<tr>
			<td>/save</td>
			<td>POST<br><pre>id (integer)</pre></td>
			<td>JSON</td>
			<td>Pass the id of the person.</td>
		</tr>
		<tr>
			<td>/delete</td>
			<td>DELETE<br><pre>id (integer)</pre></td>
			<td>JSON</td>
			<td>Pass the id of the person.</td>
		</tr>
	</tbody>
</table>



#### Status types

- <code>success</code>
- <code>error</code> (accompanied by a <code>message</code>)
- <code>info</code>






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

### 28 March 2013

- Improved docs, added screenshots
- Table view instead of Sidebar
- Redesigned top nav
- Search also searches comments now
- Added icons and buttons
- Form is now two-column instead of one
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
- Multilanguage support
- Generate tables automatically
- Smart links in detail view
- Use same date format along MySQL
- Delete comments


License
----------------

CRMx has been created by Xavi Esteve and is licensed under a MIT License.

Copyright (c) 2013 Xavi Esteve

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
