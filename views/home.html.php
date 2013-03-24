<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?=$sitename?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name='robots' content='noindex,nofollow' />
	<link href="/bootstrap.min.css" rel="stylesheet">
	<link href="/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="/style.css" rel="stylesheet">
</head>
<body>

	<!-- HEADER -->

	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container-fluid">
				<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="brand" href="/"><?=$sitename?></a>
				<div class="nav-collapse collapse">
					<p class="navbar-text pull-right">
						Logged in as <strong><?=$username?></strong> <a href="/logout" class="navbar-link" title="Logout"><i class="icon-off icon-white"></i></a>
					</p>
					<ul class="nav">
						<li class="navbar-form">
							<input id="s" class="input-large" type="text" placeholder="Start typing to search&hellip;">
						</li>
						<li><a href="/">Add new contact</a></li>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</div>
	</div>


	<!-- CONTAINER -->


	<div class="container-fluid">
		<div class="row-fluid">

			<!-- SIDEBAR -->

			<div class="span3">

				<div class="well sidebar-nav">
					<ul id="people" class="nav nav-list">
						<li class="nav-header">Loading&hellip;</li>
					</ul>
				</div><!--/.well -->

				<div class="sidebar-nav">
					<ul id="searchable" class="nav nav-list light">
						<li class="nav-header">Quick Search</li>
					</ul>
				</div><!--/.well -->

			</div><!--/span-->



			<!-- MAIN -->

			<div class="span9">

				<div class="row-fluid">
					<div class="span10">
						<input type="text" id="name" placeholder="Name">
						<input type="hidden" id="id">
						<p class="lead"><input type="text" id="title" placeholder="Title or note"></p>
					</div>
					<div class="span2">
						<p class="pull-right"><a class="save btn btn-success hide" href="#">Save contact</a></p>
					</div>
				</div>


				<div id="main" class="row-fluid">
					<div class="span4">
					
						<div id="form">
							<!-- form fields go here -->
						</div>

						<p>
							<a href="#" class="save btn btn-success hide">Save contact</a>
							<a href="#" id="delete" class="pull-right btn btn-mini btn-danger hide">Delete contact</a>
						</p>

					</div><!--/span-->
					<div class="span8">


						<div id="commentbox" class="hide">
							<h4>Comments</h4>
							
							<textarea id="c" class="span12" rows="3"></textarea>
							<p><a href="#" id="c_button" class="btn pull-right">Add comment</a></p>
						</div>

						<div id="comments">
							
						</div>


					</div><!--/span-->
				</div><!--/row-->

			</div><!--/span-->
		</div><!--/row-->


		<div id="notification" class="alert hide" title="Click to close"></div>


		<hr>

		<footer>
			<p><small>&copy; CRMx <?=date('Y')?> by <a href="http://xaviesteve.com" target="_blank">Xavi</a></small></p>
		</footer>

	</div><!--/.fluid-container-->

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>

	<script src="http://cdn.xaviesteve.com/bootstrap-collapse.js"></script>
	<script src="http://cdn.xaviesteve.com/jquery-easydate.min.js"></script>
	<script src="/script.min.js"></script>
	<script>
		$(document).ready(function(){
			// Hard-code from backend
			crmx.config = {
				sitename: '<?=$sitename?>',
				username: '<?=$username?>'
			};
			crmx.form = <?=$form?>;
			crmx.people = <?=$people?>;
			// Start the app
			crmx.run();
		});
	</script>

</body>
</html>