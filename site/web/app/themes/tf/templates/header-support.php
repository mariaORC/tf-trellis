<?php
use Roots\Sage\Assets;
use Roots\Sage\Extras;

$wrapperClass = 'support_header '.(Extras\post_is_landing_page() ? 'landing' : '');
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
			$menu = get_term(get_nav_menu_locations()['primary'], 'nav_menu');
			$menu_items = wp_get_nav_menu_items($menu->term_id);
			$topNavItems = array();

			foreach ($menu_items as $menuItem) :
				if ($menuItem->menu_item_parent == 0) {
					$topNavItems[] = '<a href="' . $menuItem->url . '">' . $menuItem->title . '</a>';
				}
			endforeach;

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
				<div class="col-sm-7 hidden-xs">
					<div id="primaryNav" class="collapse nav_wrap clearfix">
					<?php
					$nav = '';

					if (has_nav_menu('primary')) :
						$nav .= wp_nav_menu(array('theme_location' => 'support', 'menu_class' => 'nav nav-pills', 'depth' => 2, 'echo' => false));
					endif;

					$nav .= '<ul class="utility-nav nav nav-pills visible-xs">';
					$nav .= '<li id="free-trial-mobile-button"><a href="https://www.thoughtfarmer.com/engage/free-trial/">'.__('Free Trial', 'thoughtfarmer').'</a></li>';

					foreach ($menu_items as $menuItem):
						if ($menuItem->menu_item_parent == 0):
							$nav .= '<li><a href="'.$menuItem->url.'">'.$menuItem->title.'</a></li>';
						endif;
					endforeach;

					$nav .= '</ul>';

					echo $nav;
					?>
					</div>
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
<?php endif; ?>
<!--end support-header-->
