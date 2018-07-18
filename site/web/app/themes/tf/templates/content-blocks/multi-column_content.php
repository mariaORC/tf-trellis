<div class="row equalize-heights">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1 text-center">
        <?php
        echo '<h2>'.get_sub_field('title').'</h2>';

        the_sub_field('content');
        ?>
    </div>
    <?php
    $colWidth = 12 / count(get_sub_field('columns'));

    foreach (get_sub_field('columns') as $column):
        ?>
        <div class="col-xs-12 col-sm-<?php echo $colWidth; ?>">
            <div class="item">
                <div class="icon height-target text-center"><img src="<?php echo $column['icon']; ?>" alt="<?php echo $column['title']; ?>" height="84" /></div>
                <h3><?php echo $column['title']; ?></h3>
                <?php echo strip_tags($column['content'], '<ul><li><a><strong><em>'); ?>
            </div>
        </div>
        <?php
    endforeach;
    ?>
</div>
