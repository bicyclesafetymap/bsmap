<?php
class Controller_Admin_Image_Api extends Controller_Rest
{
    public $filepath     = null;
    public $current_user = null;

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

        $this->current_user = Model_User::find_by_username(Auth::get_screen_name(), []);

        $this->filepath = Config::get('config_app.filepath.point');
    }


    public function action_imageupload()
    {
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
                $point_image->save();

                // テンポラリの削除
                File::delete($paths['tmp'].'/'.$image['saved_as']);
            }

            $result = ['status' => 'OK'];
        }
        else 
        {
            $error = [];

            foreach (Upload::get_errors() as $f)
            {
                $error[] = $f['errors'][0]['message'];
            }

            $result = ['status' => 'NG', 'error' => $error];

        }

        return $this->response($result);


    }
}