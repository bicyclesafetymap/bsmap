    <fieldset>
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <span class="label label-danger">必須</span> 
                    <?= Form::label(__('common.university.name'), 'name', ['class'=>'control-label']); ?> 
                </div>
                <div class="form-group">
                    <?= Form::input('name', Input::post('name', isset($university) ? $university->name : ''), ['class' => 'col-md-4 form-control', 'placeholder' => '']); ?> 
                </div>
            </div>

            <? if (Request::active()->action === 'edit'): ?>
            <div class="col-sm-2 col-sm-offset-5">
                <div class="form-group">
                    <?= Html::anchor('admin/university/del/'.$university->id, '<i class="fa fa-times fa-lg fa-fw"></i>&nbsp;大学の削除', ['class' => 'pull-right btn btn-danger', 'onclick' => "return confirm('".$university->name."を削除してもよろしいですか？')"]); ?>
                </div>
            </div>
            <? endif; ?>
        </div><!--/.row-->

        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <span class="label label-danger">必須</span> 
                    <?= Form::label(__('common.university.latitude'), 'latitude', ['class'=>'control-label']); ?> 
                </div>
                <div class="form-group">
                    <?= Form::input('latitude', Input::post('latitude', isset($university) ? $university->latitude : ''), ['class' => 'col-md-4 form-control', 'placeholder' => '35.6840008']); ?> 
                </div>
            </div>

            <div class="col-sm-4 col-sm-offset-1">
                <div class="form-group">
                    <span class="label label-danger">必須</span> 
                    <?= Form::label(__('common.university.longitude'), 'longitude', ['class'=>'control-label']); ?> 
                </div>
                <div class="form-group">
                    <?= Form::input('longitude', Input::post('longitude', isset($university) ? $university->longitude : ''), ['class' => 'col-md-4 form-control', 'placeholder' => '130.5430513']); ?> 
                </div>
            </div>
        </div><!--/.row-->

        <div class="row">
            <div class="col-sm-2">
                <div class="form-group">
                    <span class="label label-danger">必須</span>
                    <?= Form::label(__('common.university.zoom'), 'zoom', ['class'=>'control-label']); ?> 
                </div>
                <div class="form-group">
                    <?= Form::select('zoom', Input::post('zoom', isset($university) ? $university->zoom : '14'), $conf['zoom'], ['class' => 'col-md-4 form-control']); ?>
                </div>
            </div>

            <? /* 必要なときが来るまで封印
            <div class="col-sm-2 col-sm-offset-1">
                <div class="form-group">
                    <?= Form::label(__('common.university.area'), 'area', ['class'=>'control-label']); ?> 
                </div>
                <div class="form-group">
                    <?= Form::select('area', Input::post('area', isset($university) ? $university->area : ''), $conf['area'], ['class' => 'col-md-4 form-control']); ?>
                </div>
            </div>
            */ ?>
        </div><!--/.row-->

        <div class="row">
            <div class="col-sm-7">
                <div class="form-group">
                    <?= Form::label(__('common.remarks'), 'remarks', ['class'=>'control-label']); ?> 
                </div>
                <div class="form-group">
                    <?= Form::textarea('remarks', Input::post('remarks', isset($university) ? $university->remarks : ''), ['class' => 'col-md-8 form-control', 'rows' => 8, 'placeholder'=>'2000文字まで']); ?> 
                </div>
            </div>
        </div><!--/.row-->

        <div class="form-group">
        </div>

        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label class='control-label'>&nbsp;</label>
                    <?= Form::submit('submit', '登録確認', ['class' => 'btn btn-lg btn-block btn-primary']); ?> 
                </div>
            </div>
        </div><!--/.row-->
    </fieldset>
