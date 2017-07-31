<?php
class Controller_Auth extends Controller_Template
{
    public $template = 'template_admin';

    protected $current_user;

    public function before()
    {
        parent::before();
        $this->template->set_global('current_user', $this->current_user);
        
        View::set_global('breadcrumb_status', false);

        View::set_global('title', '自転車安全マップ');
    }

    /**
     * トップメニューへ遷移
     *
     * @access  public
     * @return  void
     */
    public function action_index()
    {
        Response::redirect('signin');
    }

    /**
     * action_login 認証
     *
     * @access public
     * @return void
     */
    public function action_login()
    {
        $val = Validation::forge();

        if (Input::method() == 'POST')
        {
            $val->add('email', 'ユーザーID')
                ->add_rule('required');
            $val->add('password', 'パスワード')
                ->add_rule('required');
            $val->add('referrer', 'referrer');
            $val->add('hash', 'hash')
                ->add_rule('max_length', 100)
                ->add_rule('valid_string', ['alpha', 'numeric']);

            if ($val->run())
            {
                $auth = Auth::instance();

                if (Auth::check() or $auth->login(Input::post('email'), Input::post('password')))
                {
                    $user = Model_User::find_by_username(Auth::get_screen_name());

                    if ($user and filter_var($val->validated('referrer'), FILTER_VALIDATE_URL))
                    {
                        $query = [
                            'hash'  => $val->validated('hash'),
                            'name'  => rawurlencode($user->username),
                            'email' => rawurlencode($user->email),
                            'group' => $user->group,
                        ];
                        Response::redirect($val->validated('referrer').'?'.http_build_query($query));
                    }
                    else
                    {
                        Response::redirect('admin');
                    }

                    // ユーザーが削除されている場合はエラー表示
                    Auth::logout();
                    Session::set_flash('error', __('common.deleted_user'));
                    // $this->template->set_global('error', __('common.deleted_user'));
                }
                else
                {
                    Session::set_flash('error', __('common.login_fail'));
                    // $this->template->set_global('error', __('common.login_fail'));
                }
            }
            else
            {
                $this->template->set_global('error', $val->error());
            }
        }
        // 既にログインしている場合はリダイレクト
        else
        {
            $val->add('referrer', 'referrer');
            $val->add('hash', 'hash')
                ->add_rule('max_length', 100)
                ->add_rule('valid_string', array('alpha', 'numeric'));

            if ($val->run(['referrer' => Input::get('referrer'), 'hash' => Input::get('hash')]))
            {
                $user = Model_User::find_by_username(Auth::get_screen_name());

                if ($user and Auth::check() and filter_var($val->validated('referrer'), FILTER_VALIDATE_URL))
                {
                    $query = [
                        'hash'  => $val->validated('hash'),
                        'name'  => rawurlencode($user->screen_name),
                        'email' => rawurlencode($user->email),
                        'group' => $user->group,
                    ];
                    Response::redirect($val->validated('referrer').'?'.http_build_query($query));

                }
                else if (Auth::check())
                {
                    Response::redirect('admin');
                }
            }
        }

        $this->template->content = View::forge('auth/login', array('val' => $val), false);
    }

    /**
     * action_logout ログアウト
     *
     * @access public
     * @return void
     */
    public function action_logout()
    {
        Auth::logout();
        Response::redirect('admin');
    }


    /**
     * action_forget ID・パスワードのフォーム
     * 
     * @access public
     * @return void
     */
    // public function action_forget()
    // {
    //     $val = Formvalidations::forget();

    //     if (Input::method() == 'POST')
    //     {
    //         if ($val->run())
    //         {
    //             // 遷移用フラッシュセッションを設定して遷移
    //             Session::set('formdata', $val->validated());
    //             Response::redirect('auth/send');
    //         }
    //         else
    //         {
    //             $this->template->set_global('error', $val->error());
    //         }
    //     }

    //     $this->template->set_global('conf', Config::get('common_parameter'));

    //     $this->template->content = View::forge('auth/forget');
    // }


    /**
     * action_send ID・パスワード忘れのメール送信
     * 
     * @access public
     * @return void
     */
    // public function action_send()
    // {
    //     $formdata = Session::get('formdata');
    //     $is_mail  = false;

    //     if ( ! is_null($formdata))
    //     {
    //         // ランダム文字列の生成
    //         $key = Str::random('alnum', 30);

    //         // メールアドレスの取得
    //         $to = $formdata['email'];

    //         $user = Model_User::find('last', array(
    //             'where'  => array(array('email', '=', $to)),
    //         ));

    //         // テンポラリの登録
    //         $_temp = array(
    //             'user_id' => $user->id,
    //             'key'     => $key,
    //         );

    //         $temp = Model_Mailtemporary::forge($_temp);

    //         // 受け渡しデータの修正
    //         $_temp['user_id'] = $user->username;

    //         // メールの送信
    //         \Package::load('email');
    //         $email = Email::forge();
    //         $email->from(
    //             Config::get('config_app.email.from'),
    //             Config::get('config_app.email.from_name')
    //         );
    //         $email->subject(__('common.maildata.forget_subject'));
    //         $email->to($to);
    //         $email->body(View::forge('auth/email_forget', $_temp, false));

    //         try
    //         {
    //             $email->send();
    //             $temp->save();
    //             $is_mail = true;
    //         }
    //         catch(\EmailSendingFailedException $e)
    //         {
    //             // ドライバがメールを送信できなかったとき
    //             $is_mail = false;
    //         }
    //     }

    //     // セッションをキレイに
    //     Session::destroy();

    //     $this->template->title = 'パスワード 再発行';
    //     $this->template->content = View::forge('auth/send', array('is_mail' => $is_mail));
    // }


    /*
     * action_reset パスワードリセット確認画面
     * 
     * @param string $key 
     * @access public
     * @return void
     */
    // public function action_reset($key=null)
    // {
    //     is_null($key) and Response::redirect('auth/err');

    //     $temp = Model_Mailtemporary::find('last', array(
    //         'where' => array(
    //             array('key' => $key),
    //             array('created_at', '>=', strtotime('-15 min')),
    //         ),
    //     ));

    //     if ( ! count($temp))
    //     {
    //         Response::redirect('auth/err');
    //     }

    //     $this->template->content = View::forge('auth/reset', array('key'=>$key));
    // }

    /**
     * action_reset パスワードリセット確認画面
     * 
     * @param string $key 
     * @access public
     * @return void
     */
    // public function action_finish($key=null)
    // {
    //     is_null($key) and Response::redirect('auth/err');

    //     $temp = Model_Mailtemporary::find('last', array(
    //         'where' => array(
    //             array('key' => $key),
    //             array('created_at', '>=', strtotime('-15 min')),
    //         ),
    //     ));

    //     if (count($temp))
    //     {
    //         // パスワードリセット処理
    //         $user     = Model_User::find($temp->user_id);

    //         // データの展開
    //         $data = array(
    //             'username' => $user->username,
    //             'password' => Auth::reset_password($user->username),
    //         );

    //         // メールの送信
    //         \Package::load('email');
    //         $email = Email::forge();
    //         $email->from(
    //             Config::get('config_app.email.from'),
    //             Config::get('config_app.email.from_name')
    //         );
    //         $email->subject(__('common.maildata.reset_subject'));
    //         $email->to($user->email);
    //         $email->body(View::forge('auth/email_reset', array('data'=>$data), false));

    //         try
    //         {
    //             $email->send();
    //             $temp->delete();
    //             $is_mail = true;
    //         }
    //         catch(\EmailSendingFailedException $e)
    //         {
    //             // ドライバがメールを送信できなかったとき
    //             $is_mail = false;
    //         }
    //     }
    //     else
    //     {
    //         Response::redirect('auth/err');
    //     }

    //     $this->template->content = View::forge('auth/finish', array('is_mail' => $is_mail));
    // }



    /**
     * action_err 遷移エラー
     *
     * @access public
     * @return void
     */
    // public function action_err()
    // {
    //     $this->template->content = View::forge('auth/err');
    // }
}
/* End of file auth.php */
