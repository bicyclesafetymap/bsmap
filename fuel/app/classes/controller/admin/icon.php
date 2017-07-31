<?php
class Controller_Admin_Icon extends Controller_Admin
{
    public $filepath = null;

    public function before()
    {
        parent::before();
        ! Auth::has_access('icon.read') and Response::redirect('admin');

        $this->filepath = Config::get('config_app.filepath.icon');
    }


    /**
     * action_index アイコンの一覧表示
     *
     * @access public
     * @return void
     */
    public function action_index()
    {
        $data['icons'] = Model_Icon::find('all', [
            'order_by' => ['id' => 'desc'],
        ]);

        $this->template->set_global('filepath' , $this->filepath);
        $this->template->content = View::forge('admin/icon/index', $data);
    }


    /**
     * action_add 追加
     *
     * @access public
     * @return void
     */
    public function action_add()
    {
        ! Auth::has_access('icon.write') and Response::redirect('admin/icon');

        $this->template->content = View::forge('admin/icon/add');
    }


    /**
     * action_edit 変更
     *
     * @access public
     * @return void
     */
    public function action_edit($id = null)
    {
        (is_null($id) OR ! Auth::has_access('icon.write')) and Response::redirect('admin/icon');

        $icons = Model_Icon::find($id);

        if($icons)
        {
            $this->template->set_global('icons', $icons);
            $this->template->set_global('filepath' , $this->filepath);
            $this->template->content = View::forge('admin/icon/edit');
        }
        else
        {
            Response::redirect('admin');
        }
    }


    /**
     * action_confirm 追加確認
     *
     * @access public
     * @return void
     */
    public function action_confirm()
    {
        // 権限のチェック
        ! Auth::has_access('icon.write') and Response::redirect('admin/icon');

        // add / edit のチェック

        $type = ( ! empty(Input::post('id'))) ? true : false;

        // バリデーションの確認
        $val   = Formvalidations::icon($type);
        $error = [];

        // ファイルの有無で挙動を変更
        if ( ! Fileupload::is_file())
        {
            // $_FILES 内のアップロードされたファイルを処理する
            Upload::process(['path' => DOCROOT.$this->filepath]);

            if ($val->run() and Upload::is_valid())
            {
                // 設定にしたがって画像を保存する
                Upload::save();
                $img = Upload::get_files(0);

                $formdata = $val->validated();

                if (isset($formdata['id']) and $formdata['id'] > 0)
                {
                    $icon = Model_Icon::find($formdata['id']);

                    $icon->name   = $formdata['name'];
                    $icon->text   = $formdata['text'];
                    $icon->origin = $img['name'];
                    $icon->file   = $img['saved_as'];
                    $icon->size   = $img['size'];
                }
                else
                {
                    $_icon = [
                        'name'     => $formdata['name'],
                        'text'     => $formdata['text'],
                        'origin'   => $img['name'],
                        'file'     => $img['saved_as'],
                        'size'     => $img['size'],
                        'cagetory' => null, // 当面は使用しない
                    ];

                    $icon = Model_Icon::forge($_icon);
                }

                // 保存
                $icon->save();

                // 確認画面の表示
                Session::set_flash('success', __('common.create_success'));
                Response::redirect('admin/icon');
            }
            else 
            {
                foreach ($val->error() as $ve)
                {
                    $error[] = $ve;
                }

                foreach (Upload::get_errors() as $f)
                {
                    $error[] = $f['errors'][0]['message'];
                }

                $this->template->set_global('error', $error);

                $target = ($val->validated('id')) ? 'edit' : 'add';
                $this->template->content = View::forge('admin/icon/'.$target);
            }
        }
        else // ファイルがアップロードされていない場合
        {
            if ($val->run())
            {
                $formdata = $val->validated();

                if (isset($formdata['id']) and $formdata['id'] > 0)
                {
                    $icon = Model_Icon::find($formdata['id']);

                    $icon->name   = $formdata['name'];
                    $icon->text   = $formdata['text'];
                }
                else
                {
                    $_icon = [
                        'name'     => $formdata['name'],
                        'text'     => $formdata['text'],
                    ];

                    $icon = Model_Icon::forge($_icon);
                }

                // 保存
                $icon->save();

                // 確認画面の表示
                Session::set_flash('success', __('common.create_success'));
                Response::redirect('admin/icon');
            }
            else 
            {
                $this->template->set_global('error', $val->error());

                $target = ($val->validated('id')) ? 'edit' : 'add';
                $this->template->content = View::forge('admin/icon/'.$target);
            }
        }
    }


    /**
     * action_delimg 画像だけの削除
     *
     * @access public
     * @return void
     */
    public function action_delimg($id = null)
    {
        (is_null($id) OR ! Auth::has_access('icon.delete')) and Response::redirect('admin/icon');

        if ($icon = Model_Icon::find($id))
        {
            // ファイルとレコードの削除
            File::delete(DOCROOT.$this->filepath.'/'.$icon->file);
            $icon->file = null;
            $icon->save();

            Session::set_flash('success', __('common.delete_success'));
        }
        else
        {
            Session::set_flash('error', __('common.delete_error'));
        }

        Response::redirect('admin/icon/edit/'.$id);
    }

    /**
     * action_del レコードの削除
     *
     * @access public
     * @return void
     */
    public function action_del($id = null)
    {
        (is_null($id) OR ! Auth::has_access('icon.delete')) and Response::redirect('admin/icon');

        if ($icon = Model_Icon::find($id))
        {
            // ファイルとレコードの削除
            File::delete(DOCROOT.$this->filepath.'/'.$icon->file);
            $icon->purge();
            Session::set_flash('success', __('common.delete_success'));
        }
        else
        {
            Session::set_flash('error', __('common.delete_error'));
        }

        Response::redirect('admin/icon');
    }
}
