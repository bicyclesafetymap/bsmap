<?php
class Controller_Admin_Mypage extends Controller_Admin
{
    public function before()
    {
        parent::before();
        ! Auth::check() and Response::redirect('auth/login');
        
        $this->set_bread_status(false);
    }

    /**
     * action_password パスワード変更
     * 
     * @param string $id 
     * @access public
     * @return void
     */
    public function action_password()
    {
        
        if (Input::method() == 'POST')
        {
            $val = Formvalidations::password();

            if ($val->run())
            {
                $validated = $val->validated();

                $change = Auth::change_password(
                    $validated['current_password'],
                    $validated['new_password'],
                    $this->current_user->username
                );

                if ($change)
                {
                    Session::set_flash('success', __('common.update_success'));
                    Response::redirect('admin/mypage/password');
                }
                else
                {
                    Session::set_flash('error', __('common.update_error'));
                }
            }
            else
            {
                Session::set_flash('error', $val->error());
            }
        }

        $this->template->title   = 'パスワードの変更';
        $this->template->content = View::forge('admin/mypage/password');
    }
}