<form method="get" id="searchform" class="search-form" action="<?php echo home_url(); ?>" _lpchecked="1">
	<fieldset>
		<input type="text" name="s" id="s" value="<?php _e('Search the site','sprint'); ?>" onblur="if (this.value == '') {this.value = '<?php _e('Search the site','sprint'); ?>';}" onfocus="if (this.value == '<?php _e('Search the site','sprint'); ?>') {this.value = '';}" >
		<input id="search-image" class="sbutton" type="submit" style="border:0; vertical-align: top;" value="<?php _e('Search','sprint'); ?>">
	</fieldset>
</form>