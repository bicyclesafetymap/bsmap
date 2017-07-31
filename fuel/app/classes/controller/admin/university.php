<?php
class Controller_Admin_University extends Controller_Admin
{
    public function before()
    {
        parent::before();
        ! Auth::has_access('university.read') and Response::redirect('admin');

        $this->template->set_global('conf', Config::get('config_app'));
    }


    /**
     * action_index アイコンの一覧表示
     *
     * @access public
     * @return void
     */
    public function action_index()
    {
        $data['university'] = Model_University::find('all', [
            'order_by' => [
                'sort' => 'asc',
                'id'   => 'desc',
            ],
        ]);

        $this->template->content = View::forge('admin/university/index', $data);
    }



    /**
     * action_sort アイコンの一覧表示
     *
     * @access public
     * @return void
     */
    public function action_sort()
    {
        ! Auth::has_access('university.write') and Response::redirect('admin/university');

        if (Input::method() === 'POST')
        {
            $val = Formvalidations::university_sort();

            if ($val->run())
            {
                $formdata = $val->validated();

                foreach ($formdata as $str => $f)
                {
                    if ($f > 0)
                    {
                        $tmp = explode('_', $str);
                        $university_id = $tmp['1'];
                        
                        if ($univ = Model_University::find($university_id))
                        {
                            $univ->sort = $f;
                            $univ->save();
                        };

                        Session::set_flash('success', __('common.update_success'));
                    }
                }
            }
        }

        $data['university'] = Model_University::find('all', [
            'order_by' => [
                'sort' => 'asc',
                'id'   => 'desc',
            ],
        ]);

        $this->template->set_global('js', ['jquery-ui.min.js', 'admin/university_sort.js']);

        $this->template->content = View::forge('admin/university/sort', $data);
    }


    /**
     * action_add 追加
     *
     * @access public
     * @return void
     */
    public function action_add()
    {
        ! Auth::has_access('university.write') and Response::redirect('admin/university');

        $this->template->content = View::forge('admin/university/add');
    }


    /**
     * action_edit 変更
     *
     * @access public
     * @return void
     */
    public function action_edit($id = null)
    {
        (is_null($id) OR ! Auth::has_access('university.write')) and Response::redirect('admin/university');

        $university = Model_University::find($id);

        if($university)
        {
            $this->template->set_global('university', $university);
            $this->template->content = View::forge('admin/university/edit');
        }
        else
        {
            Response::redirect('admin');
        }
    }


    /**
     * action_confirm 追加・変更の処理
     *
     * @access public
     * @return void
     */
    public function action_confirm()
    {
        ! Auth::has_access('university.write') and Response::redirect('admin/university');

        $type = ( ! empty(Input::post('id'))) ? true : false; 

        $val = Formvalidations::university($type);

        if ($val->run())
        {
            $formdata = $val->validated();

            if (isset($formdata['id']) and $formdata['id'] > 0)
            {
                $univ = Model_University::find($formdata['id']);

                $univ->name      = $formdata['name'];
                $univ->longitude = $formdata['longitude'];
                $univ->latitude  = $formdata['latitude'];
                $univ->zoom      = $formdata['zoom'];
                // $univ->area      = $formdata['area'];
                $univ->remarks   = $formdata['remarks'];

                Session::set_flash('success', __('common.update_success'));
            }
            else
            {
                $_univ = [
                    'name'      => $formdata['name'],
                    'longitude' => $formdata['longitude'],
                    'latitude'  => $formdata['latitude'],
                    'zoom'      => $formdata['zoom'],
                    // 'area'      => $formdata['area'],
                    'remarks'   => $formdata['remarks'],
                ];

                $univ = Model_University::forge($_univ);

                Session::set_flash('success', __('common.create_success'));
            }

            // 保存
            $univ->save();

            // 確認画面の表示
            Response::redirect('admin/university');
        }
        else
        {
            $this->template->set_global('error', $val->error());

            $target = ($val->validated('id')) ? 'edit' : 'add';
            $this->template->content = View::forge('admin/university/'.$target);
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
        (is_null($id) OR ! Auth::has_access('university.delete')) and Response::redirect('admin/university');

        if ($university = Model_University::find($id))
        {
            $university->purge();
            Session::set_flash('success', __('common.delete_success'));
        }
        else
        {
            Session::set_flash('error', __('common.delete_error'));
        }

        Response::redirect('admin/university');
    }

}