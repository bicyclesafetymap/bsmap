<?php
class Controller_Admin_Top extends Controller_Admin
{

    public function action_index()
    {
        $data['tops'] = Model_Top::find('all');
        $this->template->title = "Tops";
        $this->template->content = View::forge('admin/top/index', $data);

    }

    public function action_view($id = null)
    {
        $data['top'] = Model_Top::find($id);

        $this->template->title = "Top";
        $this->template->content = View::forge('admin/top/view', $data);

    }

    public function action_create()
    {
        if (Input::method() == 'POST')
        {
            $val = Model_Top::validate('create');

            if ($val->run())
            {
                $top = Model_Top::forge(array(
                ));

                if ($top and $top->save())
                {
                    Session::set_flash('success', e('Added top #'.$top->id.'.'));

                    Response::redirect('admin/top');
                }

                else
                {
                    Session::set_flash('error', e('Could not save top.'));
                }
            }
            else
            {
                Session::set_flash('error', $val->error());
            }
        }

        $this->template->title = "Tops";
        $this->template->content = View::forge('admin/top/create');

    }

    public function action_edit($id = null)
    {
        $top = Model_Top::find($id);
        $val = Model_Top::validate('edit');

        if ($val->run())
        {

            if ($top->save())
            {
                Session::set_flash('success', e('Updated top #' . $id));

                Response::redirect('admin/top');
            }

            else
            {
                Session::set_flash('error', e('Could not update top #' . $id));
            }
        }

        else
        {
            if (Input::method() == 'POST')
            {

                Session::set_flash('error', $val->error());
            }

            $this->template->set_global('top', $top, false);
        }

        $this->template->title = "Tops";
        $this->template->content = View::forge('admin/top/edit');

    }

    public function action_delete($id = null)
    {
        if ($top = Model_Top::find($id))
        {
            $top->delete();

            Session::set_flash('success', e('Deleted top #'.$id));
        }

        else
        {
            Session::set_flash('error', e('Could not delete top #'.$id));
        }

        Response::redirect('admin/top');

    }

}
