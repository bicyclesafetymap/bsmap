<?php
class Controller_Admin_Users extends Controller_Admin
{
    public function before()
    {
        parent::before();
        ( ! Auth::has_access('user.read') OR ! Auth::check()) and Response::redirect('auth/login');

        $this->template->set_global('conf', Config::get('config_app'));
    }


    /**
     * action_index ユーザーの一覧表示
     *
     * @access public
     * @return void
     */
    public function action_index()
    {
        // ページネーション設定
        $pg = Pagination::forge('users', array(
            'pagination_url' => Uri::create('admin/users/index'),
            'total_items'    => Model_User::count(),
            'per_page'       => 200,
            'uri_segment'    => 3,
            'show_first'     => true,
            'show_last'      => true,
        ));

        $where = [['group', '<>', '100']];

        if ($this->current_user->group !== '100')
        {
            $where[] = ['university_id' => $this->current_user->university_id];
        }

        // ユーザー一覧
        $users = Model_User::find('all', [
            'where'    => $where,
            'limit'    => $pg->per_page,
            'offset'   => $pg->offset,
            'order_by' => array('id' => 'desc'),
        ]);

        // 大学一覧
        $this->set_universities();

        // ビューへの宣言
        $this->template->set_global('users', $users);

        $this->template->content = View::forge('admin/users/index');
    }


    /**
     * action_all ユーザーの一覧表示
     *
     * @access public
     * @return void
     */
    public function action_all()
    {
        // ページネーション設定
        $pg = Pagination::forge('users', array(
            'pagination_url' => Uri::create('admin/users/all'),
            'total_items'    => Model_User::count(),
            'per_page'       => 200,
            'uri_segment'    => 3,
            'show_first'     => true,
            'show_last'      => true,
        ));

        $where = [];

        if ($this->current_user->group !== '100')
        {
            $where[] = ['university_id' => $this->current_user->university_id];
        }

        // ユーザー一覧
        $users = Model_User::find('all', [
            'where'    => $where,
            'limit'    => $pg->per_page,
            'offset'   => $pg->offset,
            'order_by' => array('id' => 'desc'),
        ]);

        // 大学一覧
        $this->set_universities();

        // ビューへの宣言
        $this->template->set_global('users', $users);
        $this->template->set_global('mode', 'all');

        $this->template->content = View::forge('admin/users/index');
    }


    /**
     * action_add ユーザーの追加
     *
     * @access public
     * @return void
     */
    public function action_add()
    {
        self::permission_check('user.write', 'admin/users');

        // 大学一覧
        $this->set_universities();

        $this->template->content = View::forge('admin/users/add');
    }


    /**
     * action_confirm ユーザーの追加処理
     *
     * @access public
     * @return void
     */
    public function action_confirm()
    {
        self::permission_check('user.[write]', 'admin/users');
        (Input::method() !== 'POST') and Response::redirect('admin/users');

        $type = ( ! empty(Input::post('id'))) ? true : false;

        $val = Formvalidations::user_regist($type);

        if ($val->run())
        {
            $formdata = $val->validated();

            // 編集の場合
            if (isset($formdata['id']) and $formdata['id'] > 0)
            {
                $user = Model_User::find($formdata['id']);
                Auth::update_user([
                    'email' => $formdata['email'],
                    'group' => $formdata['group'],
                ], $user->username);

                // 管理者以外は大学必須
                if ($formdata['group'] !== '100')
                {
                    $user->university_id = $formdata['university_id'];
                }

                $user->save();

                Session::set_flash('success', 'ユーザーを'.__('common.update_success'));
            }
            else // 新規登録
            {
                $password = Str::random('alnum', 12);

                // ユーザー作成
                $_user = Auth::create_user(
                    $formdata['username'],
                    $password,
                    $formdata['email'],
                    $formdata['group']
                );

                // ユーザーが作成できなかった時はエラー処理
                if ( ! $_user)
                {
                    Session::set_flash('success', 'ユーザーを'.__('common.create_error'));
                    Response::redirect('admin/users');
                }

                // 管理者以外は大学必須
                if ($formdata['group'] !== '100')
                {
                    $user = Model_User::find($_user);
                    $user->university_id = $formdata['university_id'];

                    $user->save();
                }

                // 招待メールの送信
                \Package::load('email');
                $email = Email::forge();
                $email->from(
                    Config::get('config_app.email.from'),
                    Config::get('config_app.email.from_name')
                );
                $email->subject(Config::get('config_app.email.regist_subject'));
                // $email->bcc(Config::get('config_app.email.bcc'));
                $email->to($formdata['email']);
                $email->body(View::forge('admin/mail_template/regist', [
                    'username' => $formdata['username'],
                    'password' => $password,
                ], false));

                $email->send();

                Session::set_flash('success', 'ユーザーを'.__('common.create_success')." パスワード: ".$password);
            }

            // 処理後は一覧へ移動
            Response::redirect('admin/users');
        }
        else
        {
            $this->template->set_global('error', $val->error());

            $target = ($val->validated('id')) ? 'edit' : 'add';

            // 大学一覧
            $this->set_universities();

            $this->template->content = View::forge('admin/users/'.$target);
        }
    }


    /**
     * action_edit ユーザーの変種
     *
     * @access public
     * @return void
     */
    public function action_edit($id = null)
    {
        self::permission_check('user.[write]', 'admin/users');
        (is_null($id)) and Response::redirect('admin/users');

        $users = Model_User::find($id);

        if($users)
        {
            // 大学一覧
            $this->set_universities();

            $this->template->set_global('users', $users);
            $this->template->content = View::forge('admin/users/edit');
        }
        else
        {
            Response::redirect('admin/users');
        }
    }


    /**
     * action_del ユーザーの削除
     *
     * @access public
     * @return void
     */
    public function action_del($id = null)
    {
        self::permission_check('user.[write]', 'admin/users');
        (is_null($id)) and Response::redirect('admin/users');

        if ($user = Model_User::find($id))
        {
            Auth::delete_user($user->username);
            Session::set_flash('success', __('common.delete_success'));
        }
        else
        {
            Session::set_flash('error', __('common.delete_error'));
        }

        Response::redirect('admin/users');
    }


    /**
     * action_resetpassword パスワードのリセット
     *
     * @access public
     * @return void
     */
    public function action_resetpassword($id = null)
    {
        self::permission_check('user.[write]', 'admin/users');
        (is_null($id)) and Response::redirect('admin/users');

        if ($user = Model_User::find($id))
        {
            $password = Auth::reset_password($user->username);

            // パスワードリセットのメールの送信
            \Package::load('email');
            $email = Email::forge();
            $email->from(
                Config::get('config_app.email.from'),
                Config::get('config_app.email.from_name')
            );
            $email->subject(Config::get('config_app.email.resetpassword_subject'));
            // $email->bcc(Config::get('config_app.email.bcc'));
            $email->to($user->email);
            $email->body(View::forge('admin/mail_template/administrator_resetpassword', [
                'username' => $user->username,
                'password' => $password,
            ], false));

            $email->send();

            Session::set_flash('success', 'パスワードを変更しました。パスワード: '.$password);
        }
        else
        {
            Session::set_flash('error', __('common.delete_error'));
        }

        Response::redirect('admin/users/edit/'.$id);
    }



    /**
     * set_universities 大学一覧の取得
     *
     * @access protected
     * @return void
     */
    protected function set_universities()
    {
        // 大学一覧
        $universities = Model_University::find('all');

        if (count($universities) === 0)
        {
            Session::set_flash('error', '大学を先に登録してください。');
            Response::redirect('admin');
        }

        $this->template->set_global('universities', $universities);
    }

}
