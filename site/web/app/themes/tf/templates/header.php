<?php
use Roots\Sage\Extras;
use Roots\Sage\Assets;

if (get_field('enable_site_wide_banner', 'options')): ?>
<div class="alert-banner">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 nav-outer text-center">
				<ul id="menu-main-menu" class="nav nav-pills">
					<?php
					$bannerIcon = 'https://summit.thoughtfarmer.com/files/2015/02/thoughtfarmer-illustrations-lightbulb.png';

					if (get_field('banner_icons', 'options')):
						$bannerIcon = get_field('banner_icons', 'options');
					endif;
					?>
					<li class="menu-case-studies"><a href="<?php the_field('banner_url', 'options'); ?>" target="_blank"><img src="<?php echo $bannerIcon; ?>" style="padding-right:16px; margin-top: -3px;" width="40"><?php the_field('banner_text', 'options'); ?><img src="<?php echo $bannerIcon; ?>" style="padding-left:16px; margin-top: -3px;" width="40"></a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<?php
endif;

$wrapperClass = '';(Extras\post_is_landing_page() ? 'landing' : '');
$containerClass = 'container-fluid limit';

if (Extras\post_is_landing_page()) {
	$wrapperClass = 'landing';
	$containerClass = 'container';
}
?>
<!--begin support-header-->
<div class="header_wrap clearfix <?= $wrapperClass; ?>">
	<div class="<?= $containerClass; ?>">
		<?php
		if (!Extras\post_is_landing_page()):
			$menu = get_term(get_nav_menu_locations()['topRight'], 'nav_menu');
			$menu_items = wp_get_nav_menu_items($menu->term_id);
			$topNavItems = array();



			$topNavItems = implode(' &nbsp; ', $topNavItems);
		?>
		<div class="row topbar hidden-xs">
			<div class="col-sm-9 col-md-6 phone-numbers">
				<span class="phoneNumbers">1-888-694-3999 <?php _e('North America', 'thoughtfarmer'); ?></span> / <span class="phoneNumbers">+1 604-566-8300 <div class="visible-sm-inline"><?php _e('Intl,', 'thoughtfarmer'); ?></div><div class="visible-xs-inline visible-md-inline visible-lg-inline"><?php _e('International', 'thoughtfarmer'); ?></div></span>
				<div class="visible-sm-inline"> &nbsp;|&nbsp; <?= $topNavItems; ?></div>
			</div>
			<div class="col-sm-4 text-right hidden-sm">
				<?= $topNavItems; ?>
			</div>
			<div class="col-sm-3 col-md-2 text-right">
				<form class="searchform" method="get" action="/site-search/">
					<button type="submit" name="search" value="" class="btn btn-link btn-default searchButton"><i class="icon-search"></i></button>
					<input type="text" name="addsearch" id="s" class="text-input autohide" />
				</form>
			</div>
		</div>
		<?php endif; ?>
		<div class="row logobar">
			<div class="col-xs-9 col-sm-3">
				<a href="https://www.thoughtfarmer.com/" class="logo"><img src="<?= Assets\asset_path('images/thoughtfarmer-logo.png'); ?>" alt="<?= get_bloginfo('name'); ?>" width="174" /></a>
				<?php
					// if (get_field('show_ma_logo')):
					// 	echo '<a href="/social-merger-software/" class="logo"><img src="'.Assets\asset_path('images/thoughtfarmer-logo-ma.png').'" alt="'.get_bloginfo('name').'" width="174" /></a>';
					// else:
//					echo '<a href="'.home_url('/').'" class="logo"><img src="'.Assets\asset_path('images/thoughtfarmer-logo.png').'" alt="'.get_bloginfo('name').'" width="174" /></a>';
					// endif;
				?>
			</div>

			<?php if (!Extras\post_is_landing_page()): ?>
				<div class="col-xs-3 mobile-nav-toggle-wrap visible-xs text-right">
					<a href="#primaryNavMobile" class="mobile-nav-toggle c-hamburger c-hamburger--htx" ><span>toggle menu</span></a>
					<a href="#searchform" class="mobile-nav-toggle search-toggle icon-search"></a>
				</div>
			<?php endif; ?>

			<?php if (Extras\post_is_landing_page()): ?>
				<div class="col-xs-12 col-sm-9 text-left-xs text-right header-search">
					<span class="phoneNumbers">1-888-694-3999 <?php _e('North America', 'thoughtfarmer'); ?></span><div class="vr"></div><span class="phoneNumbers">+1 604-566-8300 <?php _e('International', 'thoughtfarmer'); ?></span>
				</div>
			<?php else: ?>
				<div class="col-sm-6 hidden-xs">
					<div id="primaryNav" class="collapse nav_wrap clearfix">
					<?php
					$nav = '';

					if (has_nav_menu('primary')) :
						$nav .= wp_nav_menu(array('theme_location' => 'primary', 'menu_class' => 'nav nav-pills', 'depth' => 2, 'echo' => false));
					endif;

					$nav .= '<ul class="utility-nav nav nav-pills visible-xs">';
					$nav .= '<li id="free-trial-mobile-button"><a href="https://www.thoughtfarmer.com/engage/free-trial/">'.__('Free Trial', 'thoughtfarmer').'</a></li>';


					$nav .= '</ul>';

					echo $nav;
					?>
					</div>
				</div>
				<div class="col-sm-3 text-right header-search hidden-xs">
					<a href="https://www.thoughtfarmer.com/engage/free-trial/" id="free-trial-button" class="btn btn-danger hidden-xs"><?php _e('Free Trial', 'thoughtfarmer'); ?></a>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php if (!Extras\post_is_landing_page()): ?>
	<div class="visible-xs">
		<div id="primaryNavMobile" class="mobile-nav-panel collapse nav_wrap clearfix">
			<?= $nav; ?>
		</div>
	</div>
	<div id="searchform" class="mobile-nav-panel collapse clearfix">
		<form class="searchform col-sm-12 visible-xs" method="get" action="/site-search/">
			<button type="submit" name="search" value="" class="btn btn-link searchButton"><i class="icon-search"></i></button>
			<input type="text" name="addsearch" id="s" class="text-input autohide" />
		</form>
	</div>
<?php
endif;

if (is_home() || is_archive() || ($post && $post->post_type == 'post')):
?>
	<div class="content-header valign-center">
		<div class="container">
			<?php get_template_part('templates/page', 'blog-header'); ?>
		</div>
	</div>
<?php
/* elseif ($post && $post->post_name == 'intranets-101'):
?>
	<div class="content-header valign-center">
		<div class="container">
			<div class="row page-intro">
				<div class="col-sm-7">asdfasdfasdfasdf
					<h1 class="mainHeading with-sub-heading"><?php the_field('intro_title'); ?></h1>
					<p class="intro"><?php the_field('intro_content'); ?></p>
				</div>
				<div class="col-sm-5">
					<?php
					$image = wp_get_attachment_image_src(get_field('intro_page_illustration'), 'full');
					echo '<a href="'.get_field('intro_video_url').'" class="videobox fancybox.iframe" title=\''.get_field('video_popup_caption').'\'><img src="'.$image[0].'" width="'.$image[1].'" height="'.$image[2].'" class="shadow alignright" /></a>';
					?>
				</div>
			</div>
		</div>
	</div>
<?php */
elseif ($post && (get_field('show_intro_title_in_header_band') || get_field('show_full_intro_in_header_band'))):
?>
	<div class="content-header valign-center">
		<div class="container">
			<?php
				if (get_field('show_intro_title_in_header_band')):
					?>
					<div class="row">
						<div class="col-xs-12 text-center">
							<h1 class="mainHeading"><?= get_field('intro_title'); ?></h1>
						</div>
					</div>
				<?php
				else:
					Extras\output_page_intro($post->ID, false, true, 'header');
				endif;
			?>
		</div>
	</div>
<?php
endif;
?>