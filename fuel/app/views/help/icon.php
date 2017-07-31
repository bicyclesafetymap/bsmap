<?= render('include/static_header'); ?>

<h2 class="staticTitle">アイコンの説明</h2>

<div class="iconInfoContainer">
    <div class="iconInfoContainer_headtext">
        地図で使われている各アイコンの意味をご説明します。
    </div>

    <? foreach ($icons as $icon): ?>
    <div class="iconInfoContainer_item">
        <div class="iconInfoContainer_inner">
            <div class="iconInfoContainer_icon">
                <?= Html::img($filepath.'/'.$icon->file); ?>
            </div>
            <div class="iconInfoContainer_title">
                <?= $icon->name; ?>
            </div>
        </div>
        <? /*
        <div class="iconInfoContainer_exp">
            <?= $icon->text; ?>
        </div>
        */ ?>
    </div>
    <? endforeach; ?>

</div>
<!-- /.iconInfoContainer -->

<?= render('include/static_footer'); ?>
