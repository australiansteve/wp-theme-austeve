<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Heisenberg
 */
?>

	</div><!-- #content -->

</div><!-- #page -->

<footer id="colophon" class="site-footer">

	<div class="column row">

		<p class="text-center">
			<a href="https://weavercrawford.com">&copy; <?php echo date("Y"); ?> Weaver Crawford Creative</a>
		</p>

	</div><!-- .column.row -->

</footer><!-- #colophon -->

<?php
	$fixedBackground = get_theme_mod('austeve_background_fixed', 'fixed');
	if ($fixedBackground == 'scroll')
	{
		echo '</div><!-- #background-div -->';
	} 
?>
<?php wp_footer(); ?>
</body>
</html>
