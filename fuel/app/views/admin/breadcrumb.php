<? if (isset($breadcrumbs)): ?>
<? $cnt = count($breadcrumbs)-1; ?>

<ol class="breadcrumb">
    <? for ($i = 0; $i < $cnt; $i++): ?>
    <? $_key = key($breadcrumbs[$i]); ?>
    <? $_key = isset($place_id1) ? preg_replace('/'.preg_quote('{{_place_id1_}}').'/', $place_id1, $_key) : $_key; ?>
    <? $_key = isset($place_id2) ? preg_replace('/'.preg_quote('{{_place_id2_}}').'/', $place_id2, $_key) : $_key; ?>
    <li><?= Html::anchor($_key, current($breadcrumbs[$i])); ?></li>
    <? endfor; ?>
    <li class="active"><?= current($breadcrumbs[$i]); ?></li>
</ol>
<? endif; ?>
