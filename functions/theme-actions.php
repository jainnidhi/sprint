<?php
$sprint_options = get_option('sprint');	

/*------------[ Meta ]-------------*/
if ( ! function_exists( 'sprint_meta' ) ) {
	function sprint_meta(){
	global $sprint_options
?>
<?php if ($sprint_options['sprint_favicon'] != ''){ ?>
	<link rel="icon" href="<?php echo $sprint_options['sprint_favicon']; ?>" type="image/x-icon" />
<?php } ?>
<!--iOS/android/handheld specific -->
<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/apple-touch-icon.png" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<?php }
}

/*------------[ Head ]-------------*/
if ( ! function_exists( 'sprint_head' ) ){
	function sprint_head() {
	global $sprint_options
?>
<?php echo $sprint_options['sprint_header_code']; ?>
<?php }
}
add_action('wp_head', 'sprint_head');

/*------------[ Copyrights ]-------------*/
if ( ! function_exists( 'sprint_copyrights_credit' ) ) {
	function sprint_copyrights_credit() { 
	global $sprint_options
?>
<!--start copyrights-->
<div class="row" id="copyright-note">
	<?php if ($sprint_options['sprint_footer_logo'] != '') { ?>
		<div class="foot-logo">
			<a href="<?php echo home_url(); ?>" rel="nofollow"><img src="<?php echo $sprint_options['sprint_footer_logo']; ?>" alt="<?php bloginfo( 'name' ); ?>"></a>
		</div>
	<?php } ?>
	<div class="copyright-left-text">Copyright &copy; <?php echo date("Y") ?> <a href="<?php echo home_url(); ?>" title="<?php bloginfo('description'); ?>" rel="nofollow"><?php bloginfo('name'); ?></a>.</div>
<div class="copyright-text"><?php echo $sprint_options['sprint_copyrights']; ?></div>
<div class="footer-navigation">
		<?php if ( has_nav_menu( 'footer-menu' ) ) { ?>
			<?php wp_nav_menu( array( 'theme_location' => 'footer-menu', 'menu_class' => 'menu', 'container' => '' ) ); ?>
		<?php } else { ?>
			<ul class="menu">
				<?php wp_list_pages('title_li='); ?>
			</ul>
		<?php } ?>
</div>
<div class="top"><a href="#top" class="toplink">&nbsp;</a></div>
</div>
<!--end copyrights-->
<?php }
}

?>