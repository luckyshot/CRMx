/*
	,o888888o.    8 888888888o.            ,8.       ,8.          `8.`8888.      ,8' 
   8888     `88.  8 8888    `88.          ,888.     ,888.          `8.`8888.    ,8'  
,8 8888       `8. 8 8888     `88         .`8888.   .`8888.          `8.`8888.  ,8'   
88 8888           8 8888     ,88        ,8.`8888. ,8.`8888.          `8.`8888.,8'    
88 8888           8 8888.   ,88'       ,8'8.`8888,8^8.`8888.          `8.`88888'     
88 8888           8 888888888P'       ,8' `8.`8888' `8.`8888.         .88.`8888.     
88 8888           8 8888`8b          ,8'   `8.`88'   `8.`8888.       .8'`8.`8888.    
`8 8888       .8' 8 8888 `8b.       ,8'     `8.`'     `8.`8888.     .8'  `8.`8888.   
   8888     ,88'  8 8888   `8b.    ,8'       `8        `8.`8888.   .8'    `8.`8888.  
	`8888888P'    8 8888     `88. ,8'         `         `8.`8888. .8'      `8.`8888. 

Copyright (c) 2013 Xavi Esteve (MIT License)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

*/

var g=[].slice;String.prototype.autoLink=function(){var e,b,d,a,c,f;c=1<=arguments.length?g.call(arguments,0):[];d="";a=c[0];f=/(^|\s)(\b(https?|ftp):\/\/[\-A-Z0-9+\u0026@#\/%?=~_|!:,.;]*[\-A-Z0-9+\u0026@#\/%=~_|])/gi;if(!(0<c.length))return this.replace(f,"$1<a href='$2'>$2</a>");null!=a.callback&&"function"===typeof a.callback&&(e=a.callback,delete a.callback);for(b in a)c=a[b],d+=" "+b+"='"+c+"'";return this.replace(f,function(a,c,b){a=e&&e(b);return""+c+(a||"<a href='"+b+"'"+d+">"+b+"</a>")})};// github.com/bryanwoods/autolink-js


var crmx = {
	config: {
		sitename: '',
		username: '',
		sort: 'name'
	},
	form: {},
	people: {},

	timer: false,

	// Methods to load stuff
	load: {

		/**
		 * load.form
		 * Generates the HTML form (without values)
		 * @params (object)
		 */
		form: function(form) {"use strict";
			$('#form').html('');
			//$('#searchable').html('');
			for (var i in form) {

				// TABLE HEADER
				// First add heading to the table thead
				if (!form[i].hidden) {
					$('#people-table>thead>tr').append('<th data-name="'+form[i].name+'">'+form[i].title+'</th>');
				}

				// detect field type and generate its html
				if (form[i].type==='select') {
					// FORM
					form[i].html = '<select id="'+form[i].name+'">';
					// TOP NAV
					$('.nav').append('<li class="dropdown">' +
						'<a href="#" class="dropdown-toggle" data-toggle="dropdown">'+form[i].title+' <span class="caret"></span></a>' +
						'<ul id="nav-drop-'+form[i].name+'" class="dropdown-menu">' +
							'</ul>' +
						'</li>');


						for (var j in form[i].list) {
							// Add to select
							form[i].html += '<option>'+form[i].list[j]+'</option>';

							// Add to top-nav
							$('#nav-drop-'+form[i].name).append('<li data-search=\'"'+form[i].name+'":"'+form[i].list[j]+'"\'><a href="#">'+form[i].list[j]+'</a></li>');

						}
					form[i].html += '</select>';

				}else{
					form[i].html = '';

					if (form[i].type == null) {
						form[i].type = 'text';
					}

					// Add special button shortcuts
					if (form[i].type==='email' || form[i].type==='search' || form[i].type==='tel' || form[i].type==='url' ) {
						form[i].html += '<div class="input-append">';
					}

					form[i].html += '<input type="'+form[i].type+'" id="'+form[i].name+'" placeholder="'+form[i].title+'">';

					// Add special button shortcuts
					if (form[i].type==='email') {
						form[i].html += '<a class="btn smart-link" data-smart="email" href="#" title="'+crmx.config.lang.emailcontact+'"><i class="icon-envelope"></i></a></div>';
					}else if (form[i].type==='search') {
						form[i].html += '<a class="btn smart-link" data-smart="search" href="#" title="'+crmx.config.lang.searchgoogle+'"><i class="icon-search"></i></a></div>';
					}else if (form[i].type==='tel') {
						form[i].html += '<a class="btn smart-link" data-smart="call" href="#" title="'+crmx.config.lang.callcontact+'"><i class="icon-bullhorn"></i></a></div>';
					}else if (form[i].type==='url') {
						form[i].html += '<a class="btn smart-link" data-smart="url" href="#" title="'+crmx.config.lang.visitwebsite+'"><i class="icon-globe"></i></a></div>';
					}
				}

				// append field
				$('#form').append(
					'<div class="control-group span6">' +
						'<label class="control-label" for="'+form[i].name+'">'+form[i].title+'</label>' +
						'<div class="controls">' +
							form[i].html +
						'</div>' +
					'</div>'
				);
			}

			// Smart Links
			$('.smart-link').on('click', function() {
				switch($(this).data('smart')) {
					case 'email':
						window.open('mailto:'+$(this).siblings('input').val(), '_blank');
					break;
					case 'search':
						window.open('https://www.google.com/search?q='+$(this).siblings('input').val(), '_blank');
					break;
					case 'call':
						window.open('skype:'+$(this).siblings('input').val()+'?call', '_blank');
					break;
					case 'url':
						window.open($(this).siblings('input').val(), '_blank');
					break;
				}
				return false;
			});


		},

		/**
		 * load.people
		 * Fill in people list
		 * @params (object) 
		 */
		people: function(people) {"use strict";
			$('#people-table>tbody').html('');
			crmx.sort(crmx.config.sort, people); // TODO: Optimize so it doesn't sort every time
			for (var i in people) {

				$('#people-table>tbody').append('<tr id="person-'+i+'"><td><a href="#" data-id="'+people[i].id+'"><button class="btn btn-mini hidden-phone"><i class="icon-search"></i></button> <strong>'+people[i].name+'</strong></a></td><td>'+people[i].form.title+'</td></tr>');

				var tr = $('#people-table>tbody>tr#person-'+i);
				for (var j in crmx.form) {
					if (!crmx.form[j].hidden) {
						tr.append('<td>'+((people[i].form[crmx.form[j].name]) ? people[i].form[crmx.form[j].name] : '')+'</td>');
					}
				}
			}
		},

		/**
		 * load.person
		 * Fills the values in name, title and form fields
		 * @params (object)
		 */
		// person: function(person) {"use strict";
		// 	// TODO
		// 	$('#commentbox').fadeIn();
		// 	for(var i in crmx.form) {
		// 		$('#'+crmx.form[i].name).val( person[crmx.form[i].name] );
		// 	}
		// },

		/**
		 * load.comments
		 * Fills the comments for that person
		 * @params (object)
		 */
		comments: function(comments) {"use strict";
			$('#comments').html('');
			for(var i in comments) {
				$('#comments').append('<blockquote>'+comments[i].text.autoLink()+'<small><em class="easydate">'+comments[i].date+'</em> '+crmx.config.lang.by+' <strong>'+comments[i].user+'</strong> <a href="#" class="comment-delete" data-id="'+comments[i].id+'" title="'+crmx.config.lang.deletecomment+'">&times;</a></small></blockquote>');
			}
			$(".easydate").easydate();
		}
	},// load


	/**
	 * refresh
	 * Asks the server for an updated list of people
	 */
	refresh: function() {"use strict";
		$('#s').val('');
		crmx.search('');
	},

	/**
	 * save
	 * Saves or Creates a person details
	 */
	save: function(){"use strict";
		crmx.notification(crmx.config.lang.loading);
		var data = {
			id: $('#id').val(),
			name: $('#name').val(),
			title: $('#title').val()
		};

		for(var i in crmx.form) {
			data[crmx.form[i].name] = $('#'+crmx.form[i].name).val();
		}

		$.ajax({
			type: "POST",
			url: "save",
			data: data
		}).done(function( response ) {
			crmx.notification( response.message, response.status );
			if (response.status==='success') {
				crmx.notification(crmx.config.lang.saved, 'success');
				$('.save').fadeOut();
				$('#delete').fadeIn();
				$('#commentbox').fadeIn();
				crmx.refresh();
				// If created a new person then select him
				if (response.id) {
					$('#id').val(response.id);
					$('#people li a[data-id='+response.id+']').parent().addClass('active');
				}
			}
		});
	},

	/**
	 * remove
	 * Deletes a person from the database
	 * @params (integer) ID of the person
	 */
	remove: function(id) {"use strict";
		if (!id) {return false;}
		if (confirm(crmx.config.lang.contactdeleteconfirm)===true) {
			crmx.notification('Deleting&hellip;');
			$.ajax({
				type: "DELETE",
				url: "delete/"+id
			}).done(function( response ) {
				crmx.notification( response.message, response.status );
				if (response.status==='success') {
					// Clean up!
					$('#name').val('');
					$('#title').val('');
					for(var i in crmx.form) {
						$('#'+crmx.form[i].name).val('');
					}
					$('.save').fadeOut();
					$('#delete').fadeOut();
					$('#commentbox').fadeOut();
					crmx.search('');
				}else{
					crmx.notification( response.message, response.status );
				}
			});
		}
	},

	/**
	 * comment
	 * Add a comment to the person
	 * @params (integer) ID of the person
	 * @params (string) Comment
	 */
	comment: function(id, comment) {"use strict";
		crmx.notification(''+crmx.config.lang.commenting+'&hellip;');
		$.ajax({
			type: "POST",
			url: "comment",
			data: {id: id, comment: comment}
		}).done(function( response ) {
			if (response.status!=='error') {
				crmx.notification();
				$('#c').val('');
				crmx.load.comments(response);
			}else{
				crmx.notification( response.message, response.status );
			}
		});
	},

	/**
	 * get
	 * Gets a person's information
	 * @params (integer) ID of the person
	 */
	get: function(id) {"use strict";
		crmx.notification(crmx.config.lang.loading+'&hellip;');
		$.ajax({
			type: "GET",
			url: "get/"+id
		}).done(function( response ) {
			if (response.status!=='error') {
				crmx.notification();

				$('#name').val(response.name);
				$('#id').val(response.id);
				$('#title').val(response.form.title);
				for(var i in crmx.form) {
					$('#'+crmx.form[i].name).val( response.form[crmx.form[i].name] );
				}

				$('.save').fadeOut();
				$('#delete').fadeIn();
				$('#commentbox').fadeIn();

				$('#people li').removeClass('active');
				$('#people li a[data-id='+id+']').parent().addClass('active');

				crmx.load.comments(response.comments);

				document.location = '#main';

			}else{
				crmx.notification( response.message, response.status );
			}
		});
	},

	/**
	 * search
	 * Searches in the database
	 * @params (string) Search query
	 */
	search: function(query) {"use strict";
		$('#people').prepend('<li class="nav-header">'+crmx.config.lang.searching+'&hellip;</li>');
		$.ajax({
			type: "GET",
			url: "search/"+query
		}).done(function( response ) {
			if (!response.status) {
				crmx.load.people(response);
			}else{
				crmx.notification( response.message, response.status );
				crmx.load.people({});
			}
		});
	},

	/**
	 * notification
	 * Shows a notification
	 * @params (string) Message or empty to hide notification
	 * @params (string) Can be ok, error or info
	 */
	notification: function(message, type) {"use strict";
		if (message==null) {
			$('#notification').stop().fadeOut('fast');
		}else{
			$('#notification')
				.html( ((type)?'<strong>'+type+'</strong> ':'')+message)
				.attr('class', 'alert alert-'+type)
				.fadeIn(500, function(){
					$(this).stop().fadeOut(10000);
			});
		}
	},


	/**
	 * updateui
	 * Shows or hides buttons to unclutter UI
	 */
	updateui: function() {"use strict";
		if ($('#id').val().length>0) {
			$('.save').fadeIn().html(crmx.config.lang.save);
			$('#delete').fadeIn();
		}else{
			$('.save').fadeIn().html(crmx.config.lang.createnew);
			$('#delete').fadeOut();
		}
	},


	/**
	 * clearform
	 * 
	 */
	clearform: function() {"use strict";
		$('#main input,#main select').val('');
		$('#delete').addClass('hide');
		crmx.updateui();
		$('#name').focus();
	},


	/**
	 * sort
	 * 
	 */
	sort: function(column, data) {"use strict";
		function createSorter(column) {
			return function (a,b) {
			if (column==='name' || column==='title') {
				var aVal = a[column], bVal = b[column];		
			}else{
				var aVal = a.form[column], bVal = b.form[column];		
			}
				return aVal > bVal ? 1 : (aVal < bVal ?  - 1 : 0);
		};
		}
		return data.sort(createSorter(column));
	},


	/**
	 * run
	 * Starts the app, loads people and form, binds events
	 */
	run: function() {"use strict";

		crmx.load.people(crmx.people);
		crmx.load.form(crmx.form);

		// Load plugins' JS and CSS
		for (var i = 0; i < crmx.config.plugins.length; i++) {
			var plugin = crmx.config.plugins[i];
			// CSS
			$.ajax({
				url: 'plugins/'+plugin+'/'+plugin+'.css',
				type:'HEAD',
				success: function() {
					$('head').append('<link href="plugins/'+plugin+'/'+plugin+'.css" rel="stylesheet">');
				}
			});
			// JS
			$.ajax({
				url: 'plugins/'+plugin+'/'+plugin+'.js',
				type:'HEAD',
				success: function() {
					$('body').append('<script src="plugins/'+plugin+'/'+plugin+'.js"></script>');
				}
			});
		}


		/********************************************
		 * Event Binding
		 ********************************************/
		// Save person
		$('.save').on('click', function(){
			crmx.save();
			return false;
		});
		// Delete person
		$('#delete').on('click', function(){
			crmx.remove( $('#id').val() );
			return false;
		});

		// Update UI (can be optimised)
		$('#form').on('change', 'select', function() {crmx.updateui();});
		$('#main').on('input paste', 'input', function() {crmx.updateui();});
		$('#name').on('input paste', function() {crmx.updateui();});
		$('#title').on('input paste', function() {crmx.updateui();});

		// Search box
		$('#s').on('input paste', function() {
			if (crmx.timer===false) {
				crmx.timer = true;
				var t = setTimeout(function(){ crmx.search($('#s').val());crmx.timer=false; }, 500);
			}
		});

		// Add comment
		$('#c_button').on('click', function(){
			if ($('#id').val().length<1) {
				crmx.notification(crmx.config.lang.selectnamefirst, 'error');
			}
			if ($('#c').val().length<1) {
				crmx.notification(crmx.config.lang.entercommentfirst, 'error');
			}
			crmx.comment($('#id').val(), $('#c').val().replace(/\n/g, '<br>'));
			return false;
		});

		// Delete comment
		$('#comments').on('click', '.comment-delete', function() {
			if(confirm(crmx.config.lang.confirmdeletecomment)) {
				$.ajax({
					type: "DELETE",
					url: "comment/"+$(this).data('id')
				}).done(function( response ) {
					crmx.notification(response.message, response.status);
					if (response.status==='success') {
						crmx.load.comments(response.comments);
					}
				});
			}
			return false;
		});

		// Top nav dropdown filters
		$('.dropdown-menu').click(function(e){
			var target = $(e.target).closest('li'); // the child that fired the original click		
			crmx.search(target.data('search'));
			$('#s').val(target.data('search'));
		});

		// Table person click
		$('#people-table').on('click', 'a', function(){
			crmx.get( $(this).data('id') );
			return false;
		});

		// Table sort by column
		$('#people-table thead').on('click', 'th', function(){
			$('#people-table th').removeClass('active');
			$(this).addClass('active');
			crmx.config.sort = $(this).data('name');
			crmx.load.people( crmx.people );
		});


		// Clear form (add new)
		$('.clearform').click(function(){crmx.clearform();});
		$('.refresh').click(function(){crmx.refresh();});

		// Notification click to hide
		$('#notification').on('click', function(){
			$(this).stop().fadeOut(200);
		});

		$('#s').focus();
	}


}; // crmx


