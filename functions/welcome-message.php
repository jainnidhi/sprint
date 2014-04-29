<?php 

add_action( 'admin_enqueue_scripts', 'sprint_point_pointer_header' );
function sprint_point_pointer_header() {
    $enqueue = false;

    $dismissed = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );

    if ( ! in_array( 'sprint_point_pointer', $dismissed ) ) {
        $enqueue = true;
        add_action( 'admin_print_footer_scripts', 'sprint_point_pointer_footer' );
    }

    if ( $enqueue ) {
        // Enqueue pointers
        wp_enqueue_script( 'wp-pointer' );
        wp_enqueue_style( 'wp-pointer' );
    }
}

function sprint_point_pointer_footer() {
    $pointer_content = '<h3>Awesomeness!</h3>';
    $pointer_content .= '<p>You have just Installed Sprint WordPress Theme by IdeaBox.</p>';
	$pointer_content .= '<p>You can Trigger The Awesomeness using this Amazing Option Panel.</p>';
    $pointer_content .= '<p>If you face any problem, head over to <a href="http://ideaboxthemes.com/support">Knowledge Base</a></p>';
?>
<script type="text/javascript">// <![CDATA[
jQuery(document).ready(function($) {
    $('#toplevel_page_theme_options').pointer({
        content: '<?php echo $pointer_content; ?>',
        position: {
            edge: 'left',
            align: 'center'
        },
        close: function() {
            $.post( ajaxurl, {
                pointer: 'sprint_point_pointer',
                action: 'dismiss-wp-pointer'
            });
        }
    }).pointer('open');
});
// ]]></script>
<?php
}

?>