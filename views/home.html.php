<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?=$sitename?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name='robots' content='noindex' />
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/style.css?v=<?=$app_version?>">
	<link rel="shortcut icon" href="favicon.png?v=<?=$app_version?>" />
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
						<strong title="<?=$lang['loggedinas']?> <?=$username?>"><?=$username?></strong> <a href="/logout" class="navbar-link" title="<?=$lang['logout']?>"><i class="icon-lock"></i></a>
					</p>
					<ul class="nav">
						<li>
							<form class="navbar-form">
								<a href="#top" class="btn" title="<?=$lang['viewtable']?>"><i class="icon-th"></i></a>
								<a href="#main" class="btn" title="<?=$lang['viewdetails']?>"><i class="icon-user"></i></a>
								<a href="#main" class="btn btn-primary clearform" title="<?=$lang['contactcreate']?>"><i class="icon-plus icon-white"></i></a>
								<input id="s" class="input-large search-query" type="text" placeholder="<?=$lang['searchplaceholder']?>&hellip;">
							</form>
						</li>
						<li class="divider-vertical"></li>
						<li><a href="/#top" title="<?=$lang['showall']?>" class="refresh"><i class="icon-refresh"></i></a></li>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</div>
	</div>


	<!-- CONTAINER -->

	<div id="table" class="container-fluid">
		<div class="row-fluid">

			<div class="span12">
				<table id="people-table" class="table table-striped table-hover table-condensed">
					<thead>
						<tr><th class="active" data-name="name"><?=$lang['name']?></th><th data-name="title"><?=$lang['title']?></th></tr>
					</thead>
					<tbody></tbody>
				</table>
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
						<input type="text" id="name" placeholder="<?=$lang['name']?>">
						<input type="hidden" id="id">
						<p class="lead"><input type="text" id="title" placeholder="<?=$lang['title']?>"></p>
					</div>
					<div class="span2">
						<p class="pull-right"><a class="save btn btn-success hide" href="#"><?=$lang['contactsave']?></a></p>
					</div>
				</div>


				<div id="main" class="row-fluid">
					<div class="span6">
					
						<div id="form">
							<!-- form fields go here -->
						</div>

						<p>
							<a href="#" class="save btn btn-success hide"><?=$lang['contactsave']?></a>
							<a href="#" id="delete" class="pull-right btn btn-mini btn-danger hide"><?=$lang['contactdelete']?></a>
						</p>

					</div><!--/span-->
					<div class="span6">

						<div id="commentbox" class="hide">
							<label><?=$lang['comments']?></label>
							
							<textarea id="c" class="span12" rows="3"></textarea>
							<p><a href="#" id="c_button" class="btn pull-right"><?=$lang['commentadd']?></a></p>
						</div>

						<div id="comments">
							<!-- comments go here -->
						</div>


					</div><!--/span-->
				</div><!--/row-->

			</div><!--/span-->
		</div><!--/row-->


		<div id="notification" class="alert hide" title="<?=$lang['clicktoclose']?>"></div>


		<footer>

			<hr>

			<div class="row-fluid">
				<div class="span6">
					<p><small>&copy; <?=date('Y')?> <a href="https://github.com/luckyshot/crmx" target="_blank">CRMx</a> <?=$app_version?> <?=$lang['by']?> <a href="http://xaviesteve.com" target="_blank">Xavi</a></small></p>
				</div>
				<div class="span6">
					<p class="tr"><a href="#top"><?=$lang['backtotop']?></a></p>
				</div>
			</div>
		</footer>

	</div><!--/.fluid-container-->

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

<!--	<script src="js/script.js?v=<?=$app_version?>"></script>
-->
	<script src="js/bootstrap-collapse.js"></script>
	<script src="js/bootstrap-dropdown.js"></script>
	<script src="js/jquery-easydate.js"></script>
	<script src="js/smoothscroll.js"></script>
	<script src="js/crmx.js"></script>

	<script>
		$(document).ready(function(){
			// Hard-code from backend
			crmx.config = {
				sitename: '<?=$sitename?>',
				username: '<?=$username?>',
				plugins: <?=$plugins?>,
				lang: <?=json_encode($lang)?>
				
			};
			crmx.form = <?=$form?>;
			crmx.people = <?=$people?>;
			// Start the app
			crmx.run();
		});
	</script>

</body>
</html>