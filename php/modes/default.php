<?php
/**
 * @file view/theme/frio/php/modes/default.php
 * @brief The default site template
 */
?>

<!DOCTYPE html >

<?php 
	require_once('view/theme/frio/php/frio_boot.php');

//	$minimal = is_modal();

?>

<html>
<head>
	<title><?php if(x($page,'title')) echo $page['title'] ?></title>
	<meta name="viewport" content="initial-scale=1.0">
	<meta request="<?php echo $_REQUEST['pagename'] ?> ">
	<script>var baseurl="<?php echo $a->get_baseurl() ?>";</script>
	<script>var frio="<?php echo "view/theme/frio"; ?>";</script>
	<?php $baseurl = $a->get_baseurl(); ?>
	<?php $frio = "view/theme/frio"; ?>
	<?php 
		// Because we use minimal for modals the header and the included js stuff should be only loaded
		// if the page is an standard page (so we don't have it twice for modals)
		// 
		/// @todo Think about to move js stuff in the footer
		if(!$minimal) {
			if(x($page,'htmlhead')) echo $page['htmlhead'];
		}
	?>
	

</head>
<?php
if(($_SERVER['REQUEST_URI'] != "/register") && ($_SERVER['REQUEST_URI'] != "/lostpass") && ($_SERVER['REQUEST_URI'] != "/login"))
{
	echo"<body id=\"top\">";
}
else
{
	echo"<body id=\"top\">";
}
?>
<?php if($_SERVER['REQUEST_URI'] == "/"){header('Location: /login');} ?>
<a href="#content" class="sr-only sr-only-focusable">Skip to main content</a>
<?php
	if(x($page,'nav') && (!$minimal)){
	echo	str_replace("~config.sitename~",get_config('config','sitename'),
			str_replace("~system.banner~",get_config('system','banner'),
			$page['nav']
	));};

	// special minimal style for modal dialogs
	if($minimal) {
?>
		<section class="minimal" style="margin:0px!important; padding:0px!important; float:none!important;display:block!important;"><?php if(x($page,'content')) echo $page['content']; ?>
			<div id="page-footer"></div>
		</section>
<?php	}
	// the style for all other pages
	else {
?>	<main>
		<div class="container">
			<div class="row">
<?php
				if(($_REQUEST['pagename'] != "register") && ($_REQUEST['pagename'] != "lostpass") && ($_REQUEST['pagename'] != "login") && ($_SERVER['REQUEST_URI'] != "/"))
				{
					echo"
					<aside class=\"col-lg-3 col-md-3 offcanvas-sm offcanvas-xs\">
						"; if(x($page,'aside')) echo $page['aside']; echo"
						"; if(x($page,'right_aside')) echo $page['right_aside']; echo"
					</aside>

					<!-- The following paragraph can maybe deleted because we don't need it anymore -->
					<div id=\"NavAside\" class=\"navmenu navmenu-default navmenu-fixed-left offcanvas hidden-lg hidden-md\">
						<div class=\"nav-container\">
							<div class=\"list-group\">
								"; if(x($page,'aside')) echo $page['aside']; echo"
								"; if(x($page,'right_aside')) echo $page['right_aside']; echo"
							</div>
						</div>
					</div><!--/.sidebar-offcanvas-->

					<div class=\"col-lg-7 col-md-7 col-sm-12 col-xs-12\" id=\"content\">
						<section class=\"sectiontop "; echo $a->argv[0]; echo "-content-wrapper\">";
								if(x($page,'content')) echo $page['content']; echo"
								<div id=\"pause\"></div> <!-- The pause/resume Ajax indicator -->
						</section>
					</div>
						";
				}
				else
				{
					echo"
					<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\" id=\"content\" style=\"margin-top:50px;\" >
						"; if(x($page,'content')) echo $page['content']; echo"
					</div>
					";
				}
?>
		
			</div><!--row-->
		</div><!-- container -->

		<div id="back-to-top" title="back to top">&#8679;</div>
	</main>

<footer>
<span id="notifsound"></span>
<script>
	$("#menu-toggle").click(function(e) {
		e.preventDefault();
		$("#wrapper").toggleClass("toggled");
	});
</script>
<script type="text/javascript">
	$.fn.enterKey = function (fnc, mod) {
		return this.each(function () {
			$(this).keypress(function (ev) {
				var keycode = (ev.keyCode ? ev.keyCode : ev.which);
				if ((keycode == '13' || keycode == '10') && (!mod || ev[mod + 'Key'])) {
					fnc.call(this, ev);
				}
			})
		})
	}
	
	$('textarea').enterKey(function() {$(this).closest('form').submit(); }, 'ctrl')
	$('input').enterKey(function() {$(this).closest('form').submit(); }, 'ctrl')
</script>

<script>
var pagetitle = null;
$("nav").bind('nav-update', function(e,data)
{
	if (pagetitle==null) pagetitle = document.title;
	var count = $(data).find('notif').attr('count');
	if (count>0)
	{
		document.title = "("+count+") "+pagetitle;
		/* document.getElementById('notifsound').innerHTML='<object type="audio/mpeg" width="0" height="0" data="<?=$frio?>/audios/901.mp3"><param name="notif" value="<?=$frio?>/audios/901.mp3" /><param name="autostart" value="true" /><param name="loop" value="false" /></object>'; */
	}
	else
	{
		document.title = pagetitle;
	}
});
</script>

<script src="<?=$frio?>/frameworks/bootstrap/js/bootstrap.min.js"></script>
<script src="<?=$frio?>/frameworks/jasny/js/jasny-bootstrap.custom.js"></script>
<script src="<?=$frio?>/frameworks/bootstrap-select/js/bootstrap-select.min.js"></script>
<script src="<?=$frio?>/frameworks/ekko-lightbox/ekko-lightbox.min.js"></script>
<script src="<?=$frio?>/frameworks/justifiedGallery/jquery.justifiedGallery.min.js"></script>
<script src="<?=$frio?>/frameworks/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="<?=$frio?>/frameworks/flexMenu/flexmenu.custom.js"></script>
<script src="<?=$frio?>/frameworks/jsmart/jsmart.js"></script>
<script src="<?=$frio?>/js/theme.js"></script>
<script src="<?=$frio?>/js/acl.js"></script>


<!-- Modal  -->
<div id="modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="plan-info" aria-hidden="true">
	<div class="modal-dialog modal-full-screen">
		<div class="modal-content">
			<div id="modal-header" class="modal-header">
				<button id="modal-cloase" type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 id="modal-title" class="modal-title"></h4>
			</div>
			<div id="modal-body" class="modal-body">
				<!-- /# content goes here -->
			</div>
		</div>
	</div>
</div>

<!-- Dummy div to append other div's when needed (e.g. used for js function editpost() -->
<div id="cache-container"></div>

</footer>
<?php } ?> <!-- End of condition if $minal else the rest -->
</body>
