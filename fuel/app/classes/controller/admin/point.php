<?php
class Controller_Admin_Point extends Controller_Admin
{
    public $filepath = null;

    public function before()
    {
        parent::before();
        self::permission_check('point.read', 'admin');

        $this->filepath = Config::get('config_app.filepath.point');

        $this->template->set_global('css', ['bootstrap-datetimepicker.min.css']);
        $this->template->set_global('js', ['moment.js', 'bootstrap-datetimepicker.min.js']);
    }


    /**
     * action_index アイコンの一覧表示
     *
     * @access public
     * @return void
     */
    public function action_index()
    {
        if ( ! Auth::has_access('point.all'))
        {
            $users = ['where' => [['university_id', '=', $this->current_user->university_id]]];
        }
        else
        {
            $users = [];
        }

        $data['points'] = Model_Point::find('all', [
            'order_by' => ['id' => 'desc'],
            'related'  => [
                'users' => $users,
            ],
        ]);

        $data['universities'] = Model_University::find('all');

        // アイコンの取得
        $this->set_icons();

        $this->template->set_global('filepath' , $this->filepath);
        $this->template->content = View::forge('admin/point/index', $data);
    }


    /**
     * action_add 追加
     *
     * @access public
     * @return void
     */
    public function action_add()
    {
        ! Auth::has_access('point.write') and Response::redirect('admin/point');

        // アイコンの取得
        $this->set_icons();

        // ビュー設定
        $this->template->js[] = 'report_map_admin.js';
        $this->template->content = View::forge('admin/point/add');
    }


    /**
     * action_edit 変更
     *
     * @access public
     * @return void
     */
    public function action_edit($id = null)
    {
        (is_null($id) OR ! Auth::has_access('point.write')) and Response::redirect('admin/point');

        $point = Model_Point::find($id, [
            'related' => ['icons'],
        ]);

        if($point)
        {
            // アイコンの取得
            $this->set_icons();

            $this->template->js[] = 'report_map_admin.js';
            $this->template->set_global('point', $point);
            $this->template->content = View::forge('admin/point/edit');
        }
        else
        {
            Response::redirect('admin/point');
        }
    }


    /**
     * action_create 追加
     *
     * @access public
     * @return void
     */
    public function action_confirm()
    {
        ! Auth::has_access('point.write') and Response::redirect('admin/point');

        $type = ( ! empty(Input::post('id'))) ? true : false; 

        $val = Formvalidations::point($type);

        if ($val->run())
        {
            $formdata = $val->validated();

            if (isset($formdata['id']) and $formdata['id'] > 0)
            {
                $point = Model_Point::find($formdata['id']);

                $point->icon_id     = $formdata['icon_id'];
                $point->longitude   = $formdata['longitude'];
                $point->latitude    = $formdata['latitude'];
                $point->video       = $formdata['video'];
                $point->streetview  = $formdata['streetview'];
                $point->name        = $formdata['name'];
                $point->text        = $formdata['text'];
                $point->happened_at = $formdata['happened_at'];
                // $point->is_open     = false;

                // 一旦空に設定
                $point->icons = [];

                if (isset($formdata['icons']) and count($formdata['icons'])>0)
                {
                    foreach ($formdata['icons'] as $f)
                    {
                        $point->icons[] = Model_Icon::find($f);
                    }
                }

                Session::set_flash('success', __('common.update_success'));
            }
            else
            {
                $_point = [
                    'icon_id'     => $formdata['icon_id'],
                    'user_id'     => $this->current_user->id,
                    'longitude'   => $formdata['longitude'],
                    'latitude'    => $formdata['latitude'],
                    'video'       => $formdata['video'],
                    'streetview'  => $formdata['streetview'],
                    'name'        => $formdata['name'],
                    'text'        => $formdata['text'],
                    'happened_at' => $formdata['happened_at'],
                    'is_open'     => false,
                ];

                $point = Model_Point::forge($_point);

                if (isset($formdata['icons']))
                {
                    foreach ($formdata['icons'] as $f)
                    {
                        $point->icons[] = Model_Icon::find($f);
                    }
                }

                Session::set_flash('success', __('common.create_success'));
            }

            // 保存
            $point->save();

            // 確認画面の表示
            Response::redirect('admin/point');
        }
        else
        {
            $this->template->set_global('error', $val->error());

            // アイコンの取得
            $this->set_icons();

            $target = ($val->validated('id')) ? 'edit' : 'add';
            $this->template->js[] = 'report_map_admin.js';
            $this->template->content = View::forge('admin/point/'.$target);
        }
    }


    /**
     * action_image 追加
     *
     * @access public
     * @return void
     */
    public function action_image($id = null, $image1=null, $image2=null, $image3=null)
    {
        (is_null($id) OR ! Auth::has_access('point.read')) and Response::redirect('admin/point');

        $point = Model_Point::find($id, ['related' => ['images']]);

        for ($i = 1; $i <= 3; $i++)
        {
            $str = 'image'.$i;
            if ( ! is_null($$str))
            {
                $image = Model_Image::find($$str, [
                    'related'  => ['users'],
                ]);
                $this->template->set_global('image'.$i, $image);
            }
        }

        // ビュー設定
        $this->template->set_global('point', $point);
        $this->template->set_global('filepath' , $this->filepath);
        $this->template->content = View::forge('admin/point/image');
    }

    /**
     * action_imageadd 画像の関連付けを登録
     *
     * @access public
     * @return void
     */
    public function action_imageadd($point_id, $image_id)
    {
        $point = Model_Point::find($point_id, [
            'related' => ['images'],
        ]);

        // 一旦空に設定
        $images = $point->images;
        $point->images = [];
        $point->images[] = Model_Image::find($image_id);

        foreach ($images as $f)
        {
            $point->images[] = $f;
        }

        $point->save();

        Session::set_flash('success', __('common.update_success'));

        Response::redirect('admin/point/image/'.$point_id);
    }


    /**
     * action_imagedel 画像の関連付けを削除
     *
     * @access public
     * @return void
     */
    public function action_imagedel($point_id, $image_id)
    {
        $point = Model_Point::find($point_id, [
            'related' => ['images'],
        ]);

        // 一旦空に設定
        $images = $point->images;
        $point->images = [];

        foreach ($images as $f)
        {
            if ($f->id !== $image_id)
            {
                $point->images[] = $f;
            }
        }

        $point->save();

        Session::set_flash('success', __('common.update_success'));

        Response::redirect('admin/point/image/'.$point_id);
    }


    /**
     * action_delimg 画像だけの削除
     *
     * @access public
     * @return void
     */
    // public function action_delimg($id = null)
    // {
    //     (is_null($id) OR ! Auth::has_access('point.delete')) and Response::redirect('admin/point');

    //     if ($point = Model_Point::find($id))
    //     {
    //         // ファイルとレコードの削除
    //         File::delete(DOCROOT.$this->filepath.'/'.$point->file);
    //         $point->file = null;
    //         $point->save();

    //         Session::set_flash('success', __('common.delete_success'));
    //     }
    //     else
    //     {
    //         Session::set_flash('error', __('common.delete_error'));
    //     }

    //     Response::redirect('admin/point/edit/'.$id);
    // }


    /**
     * action_del レコードの削除
     *
     * @access public
     * @return void
     */
    public function action_del($id = null)
    {
        (is_null($id) OR ! Auth::has_access('point.delete')) and Response::redirect('admin/point');

        if ($point = Model_Point::find($id))
        {
            // レコードの削除
            $point->purge();
            Session::set_flash('success', __('common.delete_success'));
        }
        else
        {
            Session::set_flash('error', __('common.delete_error'));
        }

        Response::redirect('admin/point');
    }


    /**
     * action_changestatus 画像の公開ステータスを変更
     *
     * @access public
     * @return void
     */
    public function action_changestatus($id = null)
    {
        (is_null($id) OR ! Auth::has_access('point.approve')) and Response::redirect('admin/image');

        $point = Model_Point::find($id);

        if($point)
        {
            $point->is_open     = ! $point->is_open;
            $point->approval_id = $this->current_user->id;
            $point->save();
        }

        $backuri = (Input::get('backuri')) ? Input::get('backuri') : 'admin' ;
        Session::set_flash('success', __('common.update_success'));

        Response::redirect_back($backuri);
    }


    /**
     * set_icons アイコン一覧の取得
     *
     * @access protected
     * @return void
     */
    protected function set_icons()
    {
        // 大学一覧
        $icons = Model_Icon::find('all');

        if (count($icons) === 0)
        {
            Session::set_flash('error', 'アイコンを先に登録してください。');
            Response::redirect('admin');
        }

        $this->template->set_global('icons', $icons);
    }


    public function action_import()
    {
        $csv = APPPATH.'tmp/import.csv';
        $this->template->content = null;
        $this->template->breadcrumb_status = false;

        $icon = [
            '1'  => '坂',
            '2'  => '信号無視',
            '3'  => '酒酔い運転による事故',
            '4'  => '交通量多',
            '5'  => '通行禁止道路の通行',
            '6'  => '安全運転義務違反',
            '7'  => '道幅',
            '8'  => '歩行者専用道路での歩行者妨害',
            '9'  => 'スピードの出しすぎ',
            '10' => '見通し',
            '11' => '歩道通行や車道の右側通行等',
            '12' => '無灯火運転',
            '13' => '暗い',
            '14' => '路側帯での歩行者通行妨害',
            '15' => '歩行者',
            '16' => '遮断踏切への立ち入り',
            '17' => '通学路',
            '18' => '左方車優先妨害・優先道路車妨害等',
            '19' => '時間帯',
            '20' => '右折時、直進車や左折車への通行妨害',
            '21' => '事故多発',
            '22' => '環状交差点安全通行義務違反',
            '23' => '重大事故',
            '24' => '一時不停止',
            '25' => 'ヒヤリハット',
            '26' => '歩道での歩行者妨害等',
            '27' => '制動装備不良の自転車の運転',
        ];

        if ( ! File::exists($csv))
        {
            echo $csv.'がありません';
            return;
        }

        $file  = fopen($csv, "r");

        if($file)
        {
            while ($line = fgets($file))
            {
                list($name, $latitude, $longitude, $video, $streetview, $_happened_at, $_icon_id, $_image, $text) = preg_split('/\t/', $line);

                $icon_id = (array_search($_icon_id, $icon)) ? array_search($_icon_id, $icon) : 19;

                $_point = [
                    'icon_id'     => $icon_id,
                    'user_id'     => $this->current_user->id,
                    'approval_id' => $this->current_user->id,
                    'longitude'   => $longitude,
                    'latitude'    => $latitude,
                    'video'       => $video,
                    'streetview'  => $streetview,
                    'name'        => $name,
                    'text'        => $text,
                    'happened_at' => preg_replace('/\//', '-', $_happened_at),
                    'is_open'     => false,
                ];

                $point = Model_Point::forge($_point);
                $point->save();


                // 画像処理
                if ($_image)
                {
                    $imagefile = file_get_contents('http://coop.275map.com/xadmins'.$_image);
                    $filename  = APPPATH.'tmp/'.$point->id.'_'.Str::random('alnum', 32).'.jpg';
                    if ($imagefile)
                    {
                        file_put_contents($filename, $imagefile);
                    }
                }

            }
        }




    }


}
