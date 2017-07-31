<!DOCTYPE html>
<html lang="ja" prefix="og: http://ogp.me/ns#">
<head>
    <?= render('include/meta'); ?>
    <? // 追加する meta の展開
    if (isset($meta))
    {
        if (is_array($meta))
        {
            foreach ($meta as $_meta)
            {
                echo render($_meta);
            }
        }
        else
        {
            echo render($meta);
        }
    } ?>
<? // 追加する css の展開
if (isset($css))
{
    if (is_array($css))
    {
        foreach ($css as $_css)
        {
            echo Asset::css($_css);
        }
    }
    else
    {
        echo Asset::css($css);
    }
} ?>
</head>
<body>
<?= render('include/analytics'); ?>

<div class="largeContainer">

<?= $content; ?>

</div>

<? // 追加する js の展開
if (isset($js))
{
    if (is_array($js))
    {
        foreach ($js as $_js)
        {
            echo Asset::js($_js);
        }
    }
    else
    {
        echo Asset::js($js);
    }
} ?>
</body>
</html>
