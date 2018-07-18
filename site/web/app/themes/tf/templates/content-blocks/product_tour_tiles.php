<?php
echo '<div class="row"><div class="col-xs-12 col-sm-6 col-sm-offset-3 lead text-center">'.get_sub_field('content').'</div></div>';

echo '<div class="row"><div class="tour-tiles clearfix equalize-item-heights">';

foreach (get_sub_field('tour_tiles') as $tile):
    echo '<div class="col-xs-12 col-sm-4"><div class="item">';
    echo '<div class="icon text-center"><a href="'.$tile['link_to'].'"><img src="'.$tile['icon'].'" alt="'.$tile['title'].'" height="84" /></a></div>';
    echo '<h3><a href="'.$tile['link_to'].'">'.$tile['title'].'</a></h3>';
    echo strip_tags($tile['content'], '<ul><li><a><strong><em>');
    echo '<p><a href="'.$tile['link_to'].'">Learn more</a></p>';
    echo '</div></div>';
endforeach;

echo '</div></div>';
