    <fieldset>
        <div class="row">
            <div class="col-sm-4">

            <? if(Request::active()->action === 'edit'): ?>
                <?= Form::hidden('id', Input::post('id', isset($icons) ? $icons->id : '')); ?>
            <? endif; ?>

                <div class="form-group">
                    <span class="label label-danger">必須</span> 
                    <?= Form::label(__('common.icon.name'), 'name', ['class'=>'control-label']); ?>
                </div>

                <div class="form-group">
                    <?= Form::input('name', Input::post('name', isset($icons) ? $icons->name : ''), ['class' => 'col-sm-4 form-control']); ?>
                </div>

                <div class="form-group">
                    <?= Form::label(__('common.icon.text'), 'text', ['class'=>'control-label']); ?>
                </div>

                <div class="form-group">
                    <?= Form::textarea('text', Input::post('text', isset($icons) ? $icons->text : ''), ['class' => 'col-sm-4 form-control', 'rows' => '6']); ?>
                </div>
                <div class="form-group">
                    <span class="label label-danger">必須</span> 
                    <?= Form::label(__('common.icon.image'), 'image', ['class'=>'control-label']); ?>
                </div>

            <? if (Request::active()->action === 'edit' and $icons->file): ?>
                <?= Html::anchor('admin/icon/delimg/'.$icons->id, '<i class="fa fa-times"></i>&nbsp;アイコンの削除', ['class' => 'pull-right btn btn-warning btn-xs btn-block', 'onclick' => "return confirm('削除してもよろしいですか？')"]); ?>
                <br><br>
                <?= Html::img($filepath.'/'.$icons->file, ['class' => 'img-responsive img-rounded']); ?>
            <? else: ?>
                <div class="form-group">
                    <div class="input_file_area">
                        <input type="file" name="origin" id="upload_file"/>
                    </div>

                    <div class="preview_area hide">
                        <p href="#" class="btn btn-default btn-xs btn-block">画像のクリア</p>
                        <p></p>
                    </div>

                    <img class="image-preview img-responsive img-rounded">
                </div>
            <? endif; ?>
            </div>

            <? if (Request::active()->action === 'edit'): ?>
            <div class="col-sm-7 col-sm-offset-1">
                <?= Html::anchor('admin/icon/del/'.$icons->id, '<i class="fa fa-times"></i>&nbsp;削除', ['class' => 'btn btn-danger', 'onclick' => "return confirm('削除してもよろしいですか？')"]); ?>
            </div>
            <? endif; ?>

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

<script>
// preview
$(document).on('change', '#upload_file', function(){
    var file       = this.files[0],       // 2. files配列にファイルが入っています
        imgtag     = $('.image-preview'), // 3. jQueryのsiblingsメソッドで兄弟のimgを取得
        fileReader = new FileReader();    // 4. ファイルを読み込むFileReaderオブジェクト

    // 1. 選択されたファイルがない場合は何もせずにreturn
    if ( ! this.files.length) {
        // プレビューをなくす
        imgtag.attr('src', '');
        return;
    }

    // 5. 読み込みが完了した際のイベントハンドラ。imgのsrcにデータをセット
    fileReader.onload = function(event) {
        $('.input_file_area').addClass('hide');
        $('.preview_area').removeClass('hide');

        // 読み込んだデータをimgに設定
        imgtag.attr('src', event.target.result);
    };

    // 6. 画像読み込み
    fileReader.readAsDataURL(file);
});

// 画像のクリア
$(document).on('click', '.preview_area', function(){
    $('.preview_area').addClass('hide');
    $('.input_file_area').removeClass('hide');

    $('#upload_file').replaceWith('<input type="file" name="origin" id="upload_file"/>');
    $('.image-preview').removeAttr('src');
});

</script>

