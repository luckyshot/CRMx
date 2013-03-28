<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?=$sitename?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name='robots' content='noindex' />
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
</head>
<body>

	<!-- HEADER -->

	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container-fluid">
				<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
				</button>
				<a class="brand" href="/"><?=$sitename?></a>
				<div class="nav-collapse collapse">
					<p class="navbar-text pull-right">
						<strong title="Logged in as <?=$username?>"><?=$username?></strong> <a href="/logout" class="navbar-link" title="Logout"><i class="icon-lock"></i></a>
					</p>
					<ul class="nav">
						<li>
							<form class="navbar-form">
								<a href="#top" class="btn" title="View table"><i class="icon-th"></i></a>
								<a href="#people-foot" class="btn" title="View details"><i class="icon-user"></i></a>
								<a href="#people-foot" class="btn btn-primary clearform" title="Add new contact"><i class="icon-plus icon-white"></i></a>
								<input id="s" class="input-large search-query" type="text" placeholder="Start typing to search&hellip;">
							</form>
						</li>
						<li class="divider-vertical"></li>
						<li><a href="/#top" title="Show all" class="refresh"><i class="icon-refresh"></i></a></li>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</div>
	</div>


	<!-- CONTAINER -->

	<div class="container-fluid">
		<div class="row-fluid">

			<div class="span12">
				<table id="people-table" class="table table-striped table-hover table-condensed">
					<thead>
						<tr><th>Name</th><th>Title</th></tr>
					</thead>
					<tbody></tbody>
					<tfoot id="people-foot"></tfoot>
				</table>
				<!-- <small><strong>Sort by: </strong> <a href="#">Name</a> / <a href="#">Recent</a></small> -->
			</div>

		</div>
	</div>


	<hr>


	<!-- CONTAINER -->

	<div id="main" class="container-fluid">
		<div class="row-fluid">

			<!-- MAIN -->

			<div class="span12">

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
					<div class="span6">
					
						<div id="form">
							<!-- form fields go here -->
						</div>

						<p>
							<a href="#" class="save btn btn-success hide">Save contact</a>
							<a href="#" id="delete" class="pull-right btn btn-mini btn-danger hide">Delete contact</a>
						</p>

					</div><!--/span-->
					<div class="span6">


						<div id="commentbox" class="hide">
							<label>Comments</label>
							
							<textarea id="c" class="span12" rows="3"></textarea>
							<p><a href="#" id="c_button" class="btn pull-right">Add comment</a></p>
						</div>

						<div id="comments">
							<!-- comments go here -->
						</div>


					</div><!--/span-->
				</div><!--/row-->

			</div><!--/span-->
		</div><!--/row-->


		<div id="notification" class="alert hide" title="Click to close"></div>


		<footer>

			<hr>

			<div class="row-fluid">
				<div class="span6">
					<p><small>&copy; CRMx <?=date('Y')?> by <a href="http://xaviesteve.com" target="_blank">Xavi</a></small></p>
				</div>
				<div class="span6">
					<p class="tr"><a href="#top">Back to top</a></p>
				</div>
			</div>
		</footer>

	</div><!--/.fluid-container-->

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

	<script src="js/script.js"></script>
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