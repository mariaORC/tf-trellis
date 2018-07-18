<?php
$contentOffsetClass = '';
$thumbOffsetClass = ' ';

if ($counter & 1) {
    $contentOffsetClass = 'col-sm-push-7';
    $thumbOffsetClass = 'col-sm-pull-5';
}

$intro = '<div class="intro-'.(get_sub_field('title_position') ? get_sub_field('title_position') : 'side').'"><h2>'.get_sub_field('title').'</h2>';

if (get_sub_field('content')):
    $intro .= '<p>'.get_sub_field('content').'</p><br/>';
endif;

$intro .= '</div>';
?>
<div class="block-content-wrapper">
    <div class="row">
        <?php if (get_sub_field('title_position') == 'top'): ?>
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 text-center">
            <?php echo $intro; ?>
            <br/>
        </div>
        <?php endif; ?>
        <div class="col-xs-12 <?php echo $contentOffsetClass; ?> col-sm-5 feature-content">
            <div class="inner">
                <div class="image-switcher" data-target="switch<?php echo $counter; ?>">
                <?php
                if (get_sub_field('title_position') != 'top'):
                    echo $intro;
                endif;

                $switcherImages = get_sub_field('switcher-images');
                $iCount = 0;

                foreach ($switcherImages as $image):
                    echo '<div class="item '.($iCount == 0 ? 'active' : '').'" data-image-src="'.$image['image'].'">';
                    echo '<h3>'.$image['title'].'</h3>';
                    echo '<p>'.$image['description'].'</p>';
                    echo '<p class="visible-xs"><img src="'.$image['image'].'" class="fade-image" /></p>';
                    echo '</div>';
                    $iCount++;
                endforeach;
                ?>
                </div>
            </div>
        </div>
        <div id="switch<?php echo $counter; ?>" class="col-xs-12 <?php echo $thumbOffsetClass; ?> col-sm-7 feature-thumb text-center hidden-xs">
            <?php
            echo '<div class="crossfader"><img src="'.$switcherImages[0]['image'].'" class="fade-image" /></div>';
            ?>
        </div>
    </div>
</div>
