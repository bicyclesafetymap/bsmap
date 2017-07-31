<?php
foreach ($icons as $k => $u)
{
    $_icons[$k] = $u->name;
}
?>
    <fieldset>

        <div class="row">
            <div class="col-sm-4">

            <? if(Request::active()->action === 'edit'): ?>
                <?= Form::hidden('id', Input::post('id', isset($point) ? $point->id : '')); ?>
            <? endif; ?>

                <div class="form-group">
                    <span class="label label-danger">必須</span>
                    <?= Form::label(__('common.point.name'), 'name', ['class'=>'control-label']); ?>
                </div>

                <div class="form-group">
                    <?= Form::input('name', Input::post('name', isset($point) ? $point->name : ''), ['class' => 'col-sm-4 form-control']); ?>
                </div>
            </div>

            <? if (Request::active()->action === 'edit'): ?>
            <div class="col-sm-7 col-sm-offset-1">
                <span class="pull-right">
                <?= Html::anchor('admin/point/image/'.$point->id, '<i class="fa fa-image"></i>&nbsp;画像', ['class' => 'btn btn-default']); ?>
                <?= Html::anchor('admin/point/del/'.$point->id, '<i class="fa fa-times"></i>&nbsp;削除', ['class' => 'btn btn-danger', 'onclick' => "return confirm('本当に削除してもよろしいですか？')"]); ?>
                </span>
            </div>
            <? endif; ?>
        </div><!--/.row-->

        <hr>

        <div class="row">
            <div class="col-sm-9" style="margin-bottom:20px;">
                <div id="changeMap"></div>
            </div>

                <div class="col-sm-3">
                    <div class="input-group" style="margin-bottom:20px;">
                        <span class="input-group-addon">緯度</span>
                        <input type="text" id="map_latitude" class="form-control input-sm" disabled>
                    </div>

                    <div class="input-group" style="margin-bottom:20px;">
                        <span class="input-group-addon">経度</span>
                        <input type="text" id="map_longitude" class="form-control input-sm" disabled>
                    </div>

                    <div class="input-group" style="margin-bottom:20px;">
                        <span class="input-group-addon">検索</span>
                        <input type="text" id="map_address" class="form-control input-sm" placeholder="例) 東京駅">
                        <span class="input-group-btn">
                            <button class="btn btn-default btn-sm" type="button" id="map_search"><i class="fa fa-search fa-lg"></i></button>
                        </span>
                    </div>
                </div>

                <div class="col-sm-12">
                    <a href="#" class="btn btn-block btn-info btn-sm" id="map_reflection"><i class="fa fa-arrow-down fa-fw fa-lg"></i>&nbsp;フォームに反映</a>
                    <p class="help-block">押すまで下部のフォームへは反映されません</p>
                </div>

        </div><!--/.row-->

        <hr>

        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <span class="label label-danger">必須</span>
                    <?= Form::label(__('common.point.latitude'), 'latitude', ['class'=>'control-label']); ?>
                </div>
                <div class="form-group">
                    <?= Form::input('latitude', Input::post('latitude', isset($point) ? $point->latitude : ''), ['class' => 'col-md-4 form-control', 'placeholder' => '35.6840008']); ?>
                </div>
            </div>

            <div class="col-sm-4 col-sm-offset-1">
                <div class="form-group">
                    <span class="label label-danger">必須</span>
                    <?= Form::label(__('common.point.longitude'), 'longitude', ['class'=>'control-label']); ?>
                </div>
                <div class="form-group">
                    <?= Form::input('longitude', Input::post('longitude', isset($point) ? $point->longitude : ''), ['class' => 'col-md-4 form-control', 'placeholder' => '130.5430513']); ?>
                </div>
            </div>

            <div class="col-sm-2 col-sm-offset-1">
                <div class="form-group">
                    &nbsp;
                </div>
                <button class="btn btn-info btn-block btn-sm" type="button" id="form_reflection"><i class="fa fa-arrow-up fa-fw fa-lg"></i>&nbsp;地図に反映</button>
            </div>
        </div><!--/.row-->



        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <?= Form::label(__('common.point.happened_at'), 'happened_at', ['class'=>'control-label']); ?>
                </div>
                <div class="form-group">
                    <div class="input-group date" id="datetimepicker">
                        <?= Form::input('happened_at', Input::post('happened_at', isset($point) ? $point->happened_at : ''), ['class' => 'col-md-4 form-control', 'id' => 'datetimepicker', 'placeholder' => '例) 2016-05-06 12:05']); ?>
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                    </div><!--/.input-group-->
                </div>
            </div>
        </div><!--/.row-->

        <div class="row">
            <div class="col-sm-9">
                <div class="form-group">
                    <?= Form::label(__('common.point.video'), 'video', ['class'=>'control-label']); ?>
                </div>
                <div class="form-group">
                    <?= Form::input('video', Input::post('video', isset($point) ? $point->video : ''), ['class' => 'col-md-4 form-control', 'placeholder' => 'https://www.youtube.com/watch?v=XXXXXXXXXXX']); ?>
                    <p class="help-block">動画リンク URL は Youtube 以外は反映されません</p>
                </div>
            </div>
        </div><!--/.row-->

        <div class="row">
            <div class="col-sm-9">
                <div class="form-group">
                    <?= Form::label(__('common.point.streetview'), 'streetview', ['class'=>'control-label']); ?>
                </div>
                <div class="form-group">
                    <?= Form::input('streetview', Input::post('streetview', isset($point) ? $point->streetview : ''), ['class' => 'col-md-4 form-control', 'placeholder' => 'https://www.google.co.jp/maps/@34.4004126,132.4655251,3a,75y,160.93h,98.7t/data=!3m7!1e1!3m5!1sm-y2bDoCw4-8eY1l2potcA!2e0!6s%2F%2Fgeo1.ggpht.com%2Fcbk%3Fpanoid%3Dm-y2bDoCw4-8eY1l2potcA%26output%3Dthumbnail%26cb_client%3Dmaps_sv.tactile.gps%26thumb%3D2%26w%3D203%26h%3D100%26yaw%3D117.39938%26pitch%3D0!7i13312!8i6656']); ?>
                </div>
            </div>
        </div><!--/.row-->

        <div class="row">
            <div class="col-sm-2">
                <div class="form-group">
                    <span class="label label-danger">必須</span>
                    <?= Form::label(__('common.point.icon_id'), 'name', ['class'=>'control-label']); ?>
                </div>
                <div class="form-group">
                    <?= Form::select('icon_id', Input::post('icon_id', isset($point) ? $point->icon_id : true), $_icons, ['class' => 'form-control']); ?>
                </div>
            </div>
        </div><!--/.row-->

        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <?= Form::label(__('common.point.icons'), 'name', ['class'=>'control-label']); ?>
                </div>
                <div class="form-group">
                    <? foreach ($icons as $k => $item): ?>
                    <label>
                    <? /*
                    <? if ($item->file): ?>
                    <?= Html::img($filepath.'/'.$item->file, ['class' => 'media-object', 'width' => 40]); ?>
                    <? else: ?>
                    <?= Asset::img('noimage.png', ['class' => 'media-object', 'width' => 40]); ?>
                    <? endif; ?>
                    */ ?>
                    <?= Form::checkbox('icons['.$k.']', $item->id, (Input::post('icons.'.$k, (isset($point) and array_key_exists($item->id, $point->icons)) ? true:false)) ? true:false, ['class' => '']); ?>
                    <?//= Form::checkbox('icons['.$k.']', $item->id, isset($point) ? (array_key_exists($item->id, $point->icons))?true:false : null, ['class' => '']); ?>
                    <?= $item->name; ?>
                    </label><br>
                    <? endforeach; ?>
                </div>
            </div>
        </div><!--/.row-->

        <? /*
        <div class="row">
            <? for ($i = 1; $i < 4; $i++): ?>
            <div class="col-sm-4">
                <div class="form-group">
                    <?= Form::label(__('common.point.image'.$i), 'image'.$i, ['class'=>'control-label']); ?>
                </div>

            <? if (Request::active()->action === 'edit' and $point->file): ?>
                <!-- 画像単位で編集できる画面へ -->
            <? else: ?>
                <div class="form-group">
                    <div class="input_file_area">
                        <input type="file" name="image<?= $i; ?>" class="upload_file"/>
                    </div>

                    <div class="preview_area hide" data-number="<?= $i; ?>">
                        <p href="#" class="btn btn-default btn-xs btn-block">画像のクリア</p>
                        <p></p>
                    </div>

                    <img class="image-preview img-responsive img-rounded">
                </div>
            <? endif; ?>
            </div>
            <? endfor; ?>

            <? if (Request::active()->action === 'edit'): ?>
            <div class="col-sm-7 col-sm-offset-1">
                <?= Html::anchor('admin/point/del/'.$point->id, '<i class="fa fa-times"></i>&nbsp;削除', ['class' => 'btn btn-danger', 'onclick' => "return confirm('削除してもよろしいですか？')"]); ?>
            </div>
            <? endif; ?>
        </div><!--/.row-->
        */ ?>

        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <?= Form::label(__('common.point.text'), 'text', ['class'=>'control-label']); ?>
                </div>

                <div class="form-group">
                    <?= Form::textarea('text', Input::post('text', isset($point) ? $point->text : ''), ['class' => 'col-sm-4 form-control', 'rows' => '6']); ?>
                </div>
            </div>
        </div><!--/.row-->

        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label class='control-label'>&nbsp;</label>
                    <?= Form::submit('submit', '登録', ['class' => 'btn btn-lg btn-block btn-primary']); ?>
                </div>
            </div>
        </div><!--/.row-->

    </fieldset>

<script src="//maps.googleapis.com/maps/api/js?key=YourGooglemapApiKeyNeed"></script>

<script type="text/javascript">
var post_latitude  <?= Input::post('latitude', isset($point) ? '= '.$point->latitude : ''); ?>;
var post_longitude <?= Input::post('longitude', isset($point) ? '= '.$point->longitude : ''); ?>;

// // 画像プレビュー
// $(document).on('change', '.upload_file', function(){
//     var base       = $(this).parent();
//     var file       = this.files[0],                      // 2. files配列にファイルが入っています
//         imgtag     = base.siblings('img.image-preview'), // 3. jQueryのsiblingsメソッドで兄弟のimgを取得
//         fileReader = new FileReader();                   // 4. ファイルを読み込むFileReaderオブジェクト

//     // 1. 選択されたファイルがない場合は何もせずにreturn
//     if ( ! this.files.length) {
//         // プレビューをなくす
//         imgtag.attr('src', '');
//         return;
//     }

//     // 5. 読み込みが完了した際のイベントハンドラ。imgのsrcにデータをセット
//     fileReader.onload = function(event) {
//         base.addClass('hide');
//         base.siblings('.preview_area').removeClass('hide');

//         // 読み込んだデータをimgに設定
//         imgtag.attr('src', event.target.result);
//     };

//     // 6. 画像読み込み
//     fileReader.readAsDataURL(file);
// });

// // 画像のクリア
// $(document).on('click', '.preview_area', function(){
//     var base = $(this),
//         num  = $(this).attr('data-number');

//     base.addClass('hide');
//     base.siblings('.input_file_area').removeClass('hide');

//     base.siblings('.input_file_area').find('.upload_file').replaceWith('<input type="file" name="image' + num + '" class="upload_file"/>');
//     base.siblings('img.image-preview').removeAttr('src');
// });

</script>
