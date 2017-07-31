<?php

class Controller_Admin extends Controller_Template
{
    public $template     = 'template_admin';
    public $current_user = null;

    /**
     * before コンストラクタ処理
     *
     * @access public
     * @return void
     */
    public function before()
    {
        parent::before();

        if (Request::active()->controller !== 'Controller_Admin' or ! in_array(Request::active()->action, ['login', 'logout']))
        {
            if (Auth::check())
            {
                if ( ! Auth::has_access('management.read'))
                {
                    Session::set_flash('error', e(__('common.access_deny')));
                    Response::redirect('/');
                }
            }
            else
            {
                Response::redirect('signin');
            }
        }

        // $this->template->set_global('environment', \Fuel::$env);

        $this->current_user = Model_User::find_by_username(Auth::get_screen_name(), [
            // 'related' => array('userdata'),
        ]);
        $this->template->set_global('current_user', $this->current_user);

        $this->template->title = Config::get('title.admin.'.Request::active()->action);

        // パンくず初期設定
        $this->set_bread_status(true);
    }


    /**
     * action_login ログイン
     *
     * @access public
     * @return void
     */
    public function action_login()
    {
        Response::redirect('signin');
    }


    /**
     * ログアウト
     *
     * @access  public
     * @return  void
     */
    public function action_logout()
    {
        Response::redirect('signout');
    }


    /**
     * INDEX
     *
     * @access  public
     * @return  void
     */
    public function action_index()
    {
        // // 参加校
        // $user = Model_User::find('all', [
        //     'where' => [['group' => '1']],
        // ]);

        // $i = 0;
        // foreach ($user as $v)
        // {
        //     $i += $v->persons;
        // }

        // $this->template->content = View::forge('admin/index', [
        //     'persons' => $i,
        //     'schools' => count($user),
        // ]);

        $this->template->breadcrumb_status = false;
        // $this->template->content = null;

        $this->template->content = View::forge('admin/index');
    }


    /**
     * パンくずの初期設定
     *
     * @access  protected
     * @return  void
     */
    protected function set_bread_status($status = true)
    {
        View::set_global('breadcrumb_status', $status);

        $breadcrumb =  Config::get('config_breadcrumb');
        $current_uri_string = Uri::string();

        foreach ($breadcrumb as $b_key => $b_val)
        {
            if (preg_match('#^'.$b_key.'#', $current_uri_string))
            {
                View::set_global('breadcrumbs', $b_val);
            }

            if (preg_match('#^'.$b_key.'#', $current_uri_string.'/index'))
            {
                View::set_global('breadcrumbs', $b_val);

            }
        }
    }


    /**
     * アクセス権限の確認
     *
     * @access  protected
     * @return  void
     */
    protected static function permission_check($role, $return)
    {
        if ( ! Auth::has_access($role))
        {
            Session::set_flash('error', __('common.permission_error'));
            Response::redirect($return);
        }

        return true;
    }
}
/* End of file admin.php */
