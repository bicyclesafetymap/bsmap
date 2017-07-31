<?php
/**
 * Formvalidations
 *
 * バリデーションの拡張（バリデーション前に通すフィルタ）
 *
 * @author Masanori Oobayashi
 */
class Formvalidations
{
    // ユーザー登録
    public static function user_regist($type=false)
    {
        $val = Validation::forge();

        if($type)
        {
            $val->add('username', __('common.username'));

            self::_id($val);

            $val->add('email', __('common.email'))
                ->add_rule(['Filter', 'conv_onebyte'])
                ->add_rule('trim')
                ->add_rule('required')
                ->add_rule('valid_keitai_email')
                ->add_rule(
                    function()
                    {
                        \Validation::active()->set_message('closure', ':label は既に使用されています');
                        $user = Model_User::find(Input::post('id'));

                        $email_count = Model_User::query()
                                        ->where('email', '<>', $user->email)
                                        ->where('email', Input::post('email'))
                                        ->count();
                        return ($email_count == 0) ? true : false ;
                    }
                )
                ->add_rule('max_length', 255)
                ->add_rule('valid_email');
        }
        else
        {
            $val->add('username', __('common.username'))
                ->add_rule(['Filter', 'conv_onebyte'])
                ->add_rule(['Filter', 'conv_kanji_num'])
                ->add_rule(['Filter', 'remove_space'])
                ->add_rule('trim')
                ->add_rule('required')
                ->add_rule('max_length', 40)
                ->add_rule('user_duplication')
                ->add_rule('valid_string', ['alpha', 'numeric', 'dashes', 'dots']);

            $val->add('email', __('common.email'))
                ->add_rule('trim')
                ->add_rule('required')
                ->add_rule('max_length', 255)
                ->add_rule('valid_email')
                ->add_rule('user_duplication');
        }

        $val->add('university_id', __('common.users.university_id'))
            ->add_rule('trim')
            ->add_rule('required')
            ->add_rule('min_length', 1)
            ->add_rule('valid_string', ['numeric']);

        $val->add('group', __('common.group'))
            ->add_rule('trim')
            ->add_rule('required')
            ->add_rule('min_length', 1)
            ->add_rule('max_length', 999)
            ->add_rule('valid_string', ['numeric']);


        return $val;
    }

    // パスワードの再設定
    public static function password()
    {
        // フォームの設定
        $val = Validation::forge();
        $val->add('current_password', __('common.current_password'))
            ->add_rule(['Filter', 'conv_onebyte'])
            ->add_rule('trim')
            ->add_rule('required')
            ->add_rule('max_length', 50)
            ->add_rule('valid_string', ['alpha', 'numeric', 'punctuation', 'dashes']);

        $val->add('new_password', __('common.new_password'))
            ->add_rule(['Filter', 'conv_onebyte'])
            ->add_rule('trim')
            ->add_rule('required')
            ->add_rule('min_length', 4)
            ->add_rule('max_length', 50)
            ->add_rule('valid_string', ['alpha', 'numeric', 'punctuation', 'dashes']);

        $val->add('confirm_password', __('common.confirm_password'))
            ->add_rule(['Filter', 'conv_onebyte'])
            ->add_rule('trim')
            ->add_rule('required')
            ->add_rule('match_field', 'new_password')
            ->add_rule('min_length', 4)
            ->add_rule('max_length', 50)
            ->add_rule('valid_string', ['alpha', 'numeric', 'punctuation', 'dashes']);

        return $val;
    }

    // パスワード忘れ
    public static function forget()
    {
        $val = Validation::forge();

        $val->add('email', __('common.email'))
            ->add_rule(['Filter', 'conv_onebyte'])
            ->add_rule('trim')
            ->add_rule('required')
            ->add_rule('max_length', 255)
            ->add_rule('valid_email')
            ->add_rule('regist_email');

        return $val;
    }


    // アイコン登録
    public static function icon($type=false)
    {
        $val = Validation::forge();

        if($type)
        {
            self::_id($val);
        }

        $val->add('name', __('common.icon.name'))
            ->add_rule('trim')
            ->add_rule('required')
            ->add_rule('max_length', 255);

        $val->add('text', __('common.icon.text'))
            ->add_rule('trim')
            ->add_rule('max_length', 2000);

        return $val;
    }

    // 大学登録
    public static function university($type=false)
    {
        $val = Validation::forge();

        if($type)
        {
            self::_id($val);
        }

        $val->add('name', __('common.university.name'))
            ->add_rule('trim')
            ->add_rule('required')
            ->add_rule('max_length', 255);

        $val->add('longitude', __('common.university.longitude'))
            ->add_rule(['Filter', 'conv_onebyte'])
            ->add_rule('trim')
            ->add_rule('required')
            ->add_rule('max_length', 20)
            ->add_rule('valid_string', ['numeric', 'dots']);

        $val->add('latitude', __('common.university.latitude'))
            ->add_rule(['Filter', 'conv_onebyte'])
            ->add_rule('trim')
            ->add_rule('required')
            ->add_rule('max_length', 20)
            ->add_rule('valid_string', ['numeric', 'dots']);

        $val->add('zoom', __('common.university.zoom'))
            ->add_rule('trim')
            ->add_rule('required')
            ->add_rule('min_length', 1)
            ->add_rule('max_length', 2)
            ->add_rule('valid_string', ['numeric']);

        $val->add('remarks', __('common.university.remarks'))
            ->add_rule('trim')
            ->add_rule('max_length', 2000);

        return $val;
    }


    // 大学の並びかえ
    public static function university_sort()
    {
        // フォームの設定
        $val = Validation::forge();

        $post = Input::post();
        unset($post['submit']);

        foreach ($post as $str => $_post)
        {
            $tmp = explode('_', $str);
            $university_id = $tmp['1'];

            $val->add('sort_'.$university_id, __('common.university.sort'))
                ->add_rule(['Filter', 'conv_onebyte'])
                ->add_rule('trim')
                ->add_rule('max_length', 3)
                ->add_rule('valid_string', ['numeric']);
        }

        return $val;
    }


    // 地点
    public static function point($type=false)
    {
        $val = Validation::forge();

        if($type)
        {
            self::_id($val);
        }

        $val->add('name', __('common.point.name'))
            ->add_rule('required')
            ->add_rule('max_length', 255);

        $val->add('happened_at', __('common.point.happened_at'))
            ->add_rule('max_length', 20);

        $val->add('icon_id', __('common.point.icon_id'))
            ->add_rule(['Filter', 'conv_onebyte'])
            ->add_rule('trim')
            ->add_rule('required')
            ->add_rule('max_length', 11)
            ->add_rule('valid_string', ['numeric']);

        $val->add('longitude', __('common.point.longitude'))
            ->add_rule(['Filter', 'conv_onebyte'])
            ->add_rule('trim')
            ->add_rule('required')
            ->add_rule('max_length', 20)
            ->add_rule('valid_string', ['numeric', 'dots']);

        $val->add('latitude', __('common.point.latitude'))
            ->add_rule(['Filter', 'conv_onebyte'])
            ->add_rule('trim')
            ->add_rule('required')
            ->add_rule('max_length', 20)
            ->add_rule('valid_string', ['numeric', 'dots']);

        $val->add('video', __('common.point.video'))
            ->add_rule('max_length', 255)
            ->add_rule('valid_url');

        $val->add('streetview', __('common.point.streetview'))
            ->add_rule('max_length', 512)
            ->add_rule('valid_url');

        if ($icons = Input::post('icons'))
        {
            foreach ($icons as $key => $icon)
            {
                $val->add('icons.'.$key, __('common.point.icons'))
                    ->add_rule(['Filter', 'conv_onebyte'])
                    ->add_rule('trim')
                    ->add_rule('max_length', 3)
                    ->add_rule('valid_string', ['numeric']);
            }
        }

        $val->add('text', __('common.point.text'))
            ->add_rule('max_length', 5000);

        return $val;
    }




    // 地点登録
    public static function report($type=false)
    {
        $val = Validation::forge('latlong');

        $val->add('latitude', __('common.university.latitude'))
            ->add_rule(['Filter', 'conv_onebyte'])
            ->add_rule('trim')
            ->add_rule('required')
            ->add_rule('max_length', 20)
            ->add_rule('valid_string', ['numeric', 'dots']);

        $val->add('longitude', __('common.university.longitude'))
            ->add_rule(['Filter', 'conv_onebyte'])
            ->add_rule('trim')
            ->add_rule('required')
            ->add_rule('max_length', 20)
            ->add_rule('valid_string', ['numeric', 'dots']);

        if ($type)
        {
            $val->add('name', __('common.point.name'))
                ->add_rule('required')
                ->add_rule('max_length', 255);

            $val->add('video', __('common.point.video'))
                ->add_rule('max_length', 255)
                ->add_rule('valid_url');


            $val->add('happened_date', __('common.point.happened_at'))
                ->add_rule('valid_ymd')
                ->add_rule('max_length', 10);

            $val->add('happened_time', __('common.point.happened_at'))
                ->add_rule('max_length', 5);

            $val->add('icon_id', __('common.point.icon_id'))
                ->add_rule(['Filter', 'conv_onebyte'])
                ->add_rule('trim')
                ->add_rule('required')
                ->add_rule('max_length', 11)
                ->add_rule('valid_string', ['numeric']);

            if ($icons = Input::post('icons'))
            {
                foreach ($icons as $key => $icon)
                {
                    $val->add('icons.'.$key, __('common.point.icons'))
                        ->add_rule(['Filter', 'conv_onebyte'])
                        ->add_rule('trim')
                        ->add_rule('max_length', 3)
                        ->add_rule('valid_string', ['numeric']);
                }
            }

            $val->add('text', __('common.point.text'))
                ->add_rule('max_length', 2000);

        }

        return $val;
    }

    // ID のみ
    public static function point_id()
    {
        $val = Validation::forge();

        $val->add('point_id', __('common.id'))
            ->add_rule(['Filter', 'conv_onebyte'])
            ->add_rule(['Filter', 'conv_kanji_num'])
            ->add_rule('trim')
            ->add_rule('required')
            ->add_rule('max_length', 11)
            ->add_rule('valid_string', ['numeric']);

        return $val;
    }


    // ID用
    protected static function _id($val)
    {
        $val->add('id', __('common.id'))
            ->add_rule(['Filter', 'conv_onebyte'])
            ->add_rule(['Filter', 'conv_kanji_num'])
            ->add_rule('trim')
            ->add_rule('required')
            ->add_rule('max_length', 11)
            ->add_rule('valid_string', ['numeric']);

        return $val;
    }

}
