CRMx
===============

CRMx is a super-simple minimal CRM (Client Relationship Management) specially aimed at flexibility and scalability. It allows for many users to work in many environments and also has a User Access Control system to define permissions for each user.

There is no Settings menu or user accounts, all is done in PHP variables (like Sublime Text) in the <code>config.php</code> file, which makes the code app a lot smaller as well as easy to administer, maintain and scale.



Technology
---------------

- Limonade PHP micro-framework (inc. custom MySQL <i>lemon</i>)
- MySQL
- JavaScript / jQuery / JSON
- Twitter Bootstrap (and LESS)



Installation
---------------

1. Open <code>config.php</code> and modify the app settings, MySQL info and prefix, customize the <code>$form</code> array and add your <code>$users</code> and their permissions
2. Open <code>dump.sql</code>, add your <code>MYSQL_PREFIX</code> (if any) and then import into database



### Logging in

There is no login screen in CRMx. Users bookmark a long URL and click on it to login. You should specify a long and unique password (at least 50 characters) for each user and then send them the URL to bookmark, which looks like:

<code>http://crmx.com/login/thesuperlongpassword</code>

	

User accounts
---------------

User accounts are created by adding them to the <code>$users</code> PHP array.

- <strong>name</strong> <small>(string)</small> Full name of the user
- <strong>pass</strong> <small>(string)</small> Add a very long random alphanumeric string of between 100 and 300 characters (the more the better, check <code>is_logged_in()</code> in the code for a generator)
- <strong>level</strong> <small>(string)</small> Add flags to allow users certain privileges
	- <strong>r</strong> <i>read</i>: useful when you want an external partner to submit contacts but not be able to read it (i.e. external lead provider)
	- <strong>s</strong> <i>save</i>: create and update contacts
	- <strong>d</strong> <i>delete</i>: can delete contacts
	- <strong>c</strong> <i>comment</i>: can comment on contacts
- <strong>dbprefix</strong> <small>(string)</small> Many users can work in different environments on the same database but using a different table. To do this, just specify a different MySQL prefix here
- <strong>sitename</strong> <small>(string)</small> Customize the app title for each user



MySQL table details
---------------

### <code>People</code> table

- <strong>id</strong> <small>(int20, primary, autoincrement)</small>
- <strong>name</strong> <small>(string255, mandatory)</small>
- <strong>form</strong> <small>(text, json)</small>
- <strong>comments</strong> <small>(text, json)</small>
- <strong>created</strong> <small>(int11)</small>
- <strong>updated</strong> <small>(int11)</small>



Environments
---------------

Environments allow users to work on separated CRMx (with their own contacts and form fields) while using the same app. To enable more environments, import the table in <code>dump.sql</code> with a new prefix and add that prefix to a user. Then add another array in <code>$form</code>. Simple as that.



Form fields
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

You can use other HTML5 form field types like: <code>color</code>, <code>date</code>, <code>datetime</code>, <code>datetime-local</code>, <code>email</code>, <code>month</code>, <code>number</code>, <code>range</code>, <code>search</code>, <code>tel</code>, <code>time</code>, <code>url</code> and <code>week</code>.

<pre>'name' => 'website',
'title' => 'Website URL',
'type' => 'url'</pre>


## Searchable functionality

Below the contact list, you can generate a list of shortcuts (links) to search that field in a click:

<pre>'searchable' => 1,</pre>

Note: Values in select dropdowns that are "<code>-</code>" are not added to the list.


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

