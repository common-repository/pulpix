<?php
function myscript() {
?>

<?php if (get_option('pulpix_options') and get_option('pulpix_options')['pulpix_field_website_id']) { ?>
<script type="text/javascript">
 // This depends on jquery

 var pulpixId= <?php echo get_option('pulpix_options')['pulpix_field_website_id'] ?>;!function(e,t){var i=t.createElement("script"),
r=t.getElementsByTagName("script")[0];i.src="https://cdn.pulpix.com/static/pulpix.js",
i.id="pulpix",i.setAttribute("data-user-id",pulpixId),
r.parentNode.insertBefore(i,r)}(window,document);
</script>
<?php
}

}
add_action('wp_footer', 'myscript');
