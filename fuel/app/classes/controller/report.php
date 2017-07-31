<?
class Controller_Report extends Controller_Admin
{
    public $template = 'template';
    public $filepath = null;

    public function before()
    {
        parent::before();
        ( ! Auth::has_access('user.read') OR ! Auth::check()) and Response::redirect('auth/login');

        $this->template->set_global('conf', Config::get('config_app'));
        $this->filepath = Config::get('config_app.filepath.point');
    }


    /**
     * action_index latlong へのリダイレクト
     *
     * @access  public
     * @return  Response
     */
    public function action_index()
    {
        Response::redirect('report/latlong');
    }


    /**
     * action_latlong ステップ１ 地点を地図から選択
     *
     * @access  public
     * @return  Response
     */
    public function action_latlong()
    {
        // 前の画面から戻ってきたとき
        if (Input::method() === 'POST')
        {
            // CSRF
            self::check_token();

            // 画面がどこから戻ってきたかでバリデーションを変える
            $type = (empty(Input::post('name'))) ? false : true ;

            $val = Formvalidations::report($type);

            if ($val->run())
            {
                $this->template->set_global('data', $val->validated());
            }
        }

        $this->template->set_global('js', ['report_map.js']);
        $this->template->content = View::forge('report/latlong');
    }


    /**
     * action_input ステップ２ データ入力
     *
     * @access  public
     * @return  Response
     */
    public function action_input()
    {
        Input::method() !== 'POST' and Response::redirect('report');

        // CSRF
        self::check_token();

        $type = (empty(Input::post('name'))) ? false : true ;

        $val = Formvalidations::report($type);

        if ($val->run())
        {
            $this->set_icons();

            $this->template->set_global('data', $val->validated());
            $this->template->set_global('js', [
                'report_input.js',
                'plugin/pickadate/picker.js',
                'plugin/pickadate/picker.date.js',
                'plugin/pickadate/picker.time.js',
                'plugin/pickadate/translations/ja_JP.js'
            ]);

            $this->template->content = View::forge('report/input');
        }
        else // latlong 再描画
        {
            $this->template->set_global('error', $val->error());

            $this->template->set_global('js', ['report_map.js']);
            $this->template->content = View::forge('report/latlong');
        }
    }


    /**
     * action_confirm ステップ３ 入力された値の確認
     *
     * @access  public
     * @return  Response
     */
    public function action_confirm()
    {
        Input::method() !== 'POST' and Response::redirect('report');

        // CSRF
        self::check_token();

        $val = Formvalidations::report(true);

        $this->set_icons();

        if ($val->run())
        {
            $this->template->set_global('data', $val->validated());

            $this->template->set_global('js', ['data_confirm.js']);
            $this->template->content = View::forge('report/confirm');
        }
        else // latlong 再描画
        {
            $this->template->set_global('error', $val->error());

            // 緯度経度再設定
            $this->template->set_global('data', [
                'latitude'  => $val->validated('latitude'),
                'longitude' => $val->validated('longitude'),
            ]);

            $this->template->set_global('js', [
                'report_input.js',
                'plugin/pickadate/picker.js',
                'plugin/pickadate/picker.date.js',
                'plugin/pickadate/picker.time.js',
                'plugin/pickadate/translations/ja_JP.js'
            ]);

            $this->template->content = View::forge('report/input');
        }
    }


    /**
     * action_finish ステップ４ 登録の処理
     *
     * @access  public
     * @return  Response
     */
    public function action_finish()
    {
        Input::method() !== 'POST' and Response::redirect('report');

        // CSRF
        self::check_token();

        $val = Formvalidations::report(true);

        $this->set_icons();

        if ($val->run())
        {
            $formdata = $val->validated();

            $_point = [
                'icon_id'     => $formdata['icon_id'],
                'user_id'     => $this->current_user->id,
                'longitude'   => $formdata['longitude'],
                'latitude'    => $formdata['latitude'],
                'video'       => $formdata['video'],
                'streetview'  => '',
                'name'        => $formdata['name'],
                'text'        => $formdata['text'],
                'happened_at' => $formdata['happened_date'].' '.$formdata['happened_time'],
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

            // 保存
            $point->save();

            $this->template->set_global('point_id', $point->id);
            $this->template->content = View::forge('report/finish');
        }
        else // latlong 再描画
        {
            // 最初に戻る
            Response::redirect('report');
        }
    }


    /**
     * action_image ステップ５ 画像の登録画面
     *
     * @access  public
     * @return  Response
     */
    public function action_image()
    {
        Input::method() !== 'POST' and Response::redirect('report');

        // CSRF
        self::check_token();

        $val = Formvalidations::point_id();

        if ($val->run())
        {
            $this->template->set_global('point_id', $val->validated('point_id'));
            $this->template->set_global('js', ['report_image.js']);
            $this->template->content = View::forge('report/image');
        }
        else // latlong 再描画
        {
            // 最初に戻る
            Response::redirect('report');
        }
    }


    /**
     * action_upload ステップ５ 画像の登録画面
     *
     * @access  public
     * @return  Response
     */
    public function action_upload()
    {
        Input::method() !== 'POST' and Response::redirect('report');

        // CSRF
        self::check_token();

        $val = Formvalidations::point_id();

        if ($val->run())
        {
            // $point_id = $val->validated('point_id');

            // ファイルの保存パス
            $paths = [
                'tmp'       => DOCROOT.$this->filepath.'/tmp',
                'thumbnail' => DOCROOT.$this->filepath.'/thumbnail',
                'original'  => DOCROOT.$this->filepath.'/original',
            ];

            // $_FILES 内のアップロードされたファイルを処理する
            Upload::process(['path' => $paths['tmp']]);

            if (Upload::is_valid())
            {
                // 画像の一時保存
                Upload::save();

                // 画像処理
                $images = Upload::get_files();

                foreach ($images as $image)
                {
                    // オリジナルとサムネイルの生成
                    Fileupload::create_original($image,  $paths['original']);
                    Fileupload::create_thumbnail($image, $paths['thumbnail']);

                    // DB 登録情報の作成
                    $_point_image = [
                        'user_id'  => $this->current_user->id,
                        'origin'   => $image['saved_as'],
                        'file'     => $image['saved_as'],
                        'size'     => $image['size'],
                        'is_open'  => false,
                    ];

                    $point_image = Model_Image::forge($_point_image);
                    $point_image->points[] = Model_Point::find($val->validated('point_id'));

                    $point_image->save();

                    // テンポラリの削除
                    File::delete($paths['tmp'].'/'.$image['saved_as']);
                }
            }

            $this->template->content = View::forge('report/upload');
        }
        else // latlong 再描画
        {
            // 最初に戻る
            Response::redirect('report');
        }
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


    /**
     * check_token 認証キーチェック
     *
     * @access protected
     * @return void
     */
    protected static function check_token()
    {
        if ( ! Security::check_token())
        {
            Response::redirect('report');
        }
    }
}

