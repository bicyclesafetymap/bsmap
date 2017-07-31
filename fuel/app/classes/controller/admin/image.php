<?php
class Controller_Admin_Image extends Controller_Admin
{
    public $filepath = null;

    public function before()
    {
        parent::before();
        self::permission_check('image.read', 'admin');

        $this->filepath = Config::get('config_app.filepath.point');

        $this->template->set_global('css', ['bootstrap-datetimepicker.min.css']);
        $this->template->set_global('js', ['moment.js', 'bootstrap-datetimepicker.min.js']);
    }


    /**
     * action_index 画像の一覧表示
     *
     * @access public
     * @return void
     */
    public function action_index()
    {
        if ( ! Auth::has_access('image.all'))
        {
            $users = ['where' => [['university_id', '=', $this->current_user->university_id]]];
        }
        else
        {
            $users = [];
        }

        $pg = Pagination::forge('images', [
            'pagination_url' => Uri::create('admin/image/index'),
            'total_items'    => Model_Image::count(),
            'per_page'       => 50,
            'uri_segment'    => 4,
            'show_first'     => true,
            'show_last'      => true,
        ]);

        $data['images'] = Model_Image::find('all', [
            'limit'    => $pg->per_page,
            'offset'   => $pg->offset,
            'order_by' => ['id' => 'desc'],
            'related'  => ['users' => $users, 'points'],
        ]);

        $this->template->set_global('filepath' , $this->filepath);
        $this->template->content = View::forge('admin/image/index', $data);
    }


    /**
     * action_select 画像の一覧表示
     *
     * @access public
     * @return void
     */
    public function action_select($point_id=null)
    {
        (is_null($point_id)) and Response::redirect('admin/point');

        $this->set_bread_status(false);

        $pg = Pagination::forge('images', [
            'pagination_url' => Uri::create('admin/image/select/'.$point_id),
            'total_items'    => Model_Image::count(),
            'per_page'       => 50,
            'uri_segment'    => 5,
            'show_first'     => true,
            'show_last'      => true,
        ]);

        $data['images'] = Model_Image::find('all', [
            'limit'    => $pg->per_page,
            'offset'   => $pg->offset,
            'order_by' => ['id' => 'desc'],
            'related'  => ['users', 'points'],
        ]);

        $this->template->set_global('point_id' , $point_id);
        $this->template->set_global('filepath' , $this->filepath);
        $this->template->content = View::forge('admin/image/select', $data);
    }


    /**
     * action_add 追加
     *
     * @access public
     * @return void
     */
    public function action_add()
    {
        ! Auth::has_access('image.write') and Response::redirect('admin/image');

        // ビュー設定
        $this->template->set_global('filepath' , $this->filepath);
        $this->template->content = View::forge('admin/image/add');
    }


    /**
     * action_edit 変更
     *
     * @access public
     * @return void
     */
    public function action_edit($id = null)
    {
        (is_null($id) OR ! Auth::has_access('image.write')) and Response::redirect('admin/image');

        $image = Model_Point::find($id, [
            'related' => ['icons'],
        ]);

        if($image)
        {
            // アイコンの取得
            $this->set_icons();

            $this->template->set_global('image', $image);
            // $this->template->set_global('filepath' , $this->filepath);
            $this->template->content = View::forge('admin/image/edit');
        }
        else
        {
            Response::redirect('admin/image');
        }
    }


    /**
     * action_del レコードの削除
     *
     * @access public
     * @return void
     */
    public function action_del($id = null)
    {
        (is_null($id) OR ! Auth::has_access('image.delete')) and Response::redirect('admin/image');

        if ($image = Model_Image::find($id))
        {
            // ファイルとレコードの削除
            if (File::exists(DOCROOT.$this->filepath.'/original/'.$image->file))
            {
                File::delete(DOCROOT.$this->filepath.'/original/'.$image->file);
            }

            if (File::exists(DOCROOT.$this->filepath.'/thumbnail/'.$image->file))
            {
                File::delete(DOCROOT.$this->filepath.'/thumbnail/'.$image->file);
            }

            $image->delete();
            Session::set_flash('success', __('common.delete_success'));
        }
        else
        {
            Session::set_flash('error', __('common.delete_error'));
        }

        Response::redirect('admin/image');
    }

    /**
     * action_changestatus 画像の公開ステータスを変更
     *
     * @access public
     * @return void
     */
    public function action_changestatus($id = null)
    {
        (is_null($id) OR ! Auth::has_access('image.approve')) and Response::redirect('admin/image');

        $image = Model_Image::find($id);

        if($image)
        {
            $image->is_open     = ! $image->is_open;
            $image->approval_id = $this->current_user->id;
            $image->save();
        }

        $backuri = (Input::get('backuri')) ? Input::get('backuri') : 'admin' ;
        Session::set_flash('success', __('common.update_success'));

        Response::redirect_back($backuri);
    }

}
