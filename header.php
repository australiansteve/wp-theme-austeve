<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Heisenberg
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php
$svg_sprite = file_get_contents( get_template_directory() . '/_dist/sprite/sprite.svg' );
if ( file_exists( $svg_sprite ) ) {
	echo $svg_sprite;
} 

$fixedBackground = get_theme_mod('austeve_background_fixed', 'fixed');
$backgrounds = get_theme_mod('austeve_backgrounds', 0);
$onlyforhome = get_theme_mod('austeve_background_homeonly', false);
$pageClasses = is_home() ? "homepage" : "";

if ($fixedBackground == 'fixed') 
{
	//Fixed
?>
	<div id="background-div" class="fixed">
<?php
		for ($b = 0; $b < $backgrounds; $b++) {
			if (!$onlyforhome || is_home())
			{
				echo '<div id="bgImage'.($b+1).'" class="bgImage">&nbsp;</div>';
			}
		}
?>
	</div>
	
	<div id="page" class="<?php echo $pageClasses; ?>">

<?php 
}
else
{
	//Scrolling
?>
	<div id="background-div" class="scrolling">
<?php
		for ($b = 0; $b < $backgrounds; $b++) {
			if (!$onlyforhome || is_home())
			{
				echo '<div id="bgImage'.($b+1).'" class="bgImage">&nbsp;</div>';
			}	
		}
?>

		<div id="page" class="<?php echo $pageClasses; ?>">
<?php
}
?>

<header id="masthead">
	<section class="row column">
		<h1 class="site-title">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<?php echo esc_html( get_bloginfo( 'name' ) ); ?>
			</a>
		</h1>
		<h2 class="site-description"><?php echo esc_html( get_bloginfo( 'description' ) ); ?></h2>
	</section>
	<?php
	$args = [
		'theme_location' => 'primary',
		'container'      => '',
	];
	wp_nav_menu( $args ); ?>
</header>
<div id="content" class="site-content" role="main">