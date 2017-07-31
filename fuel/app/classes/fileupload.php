<?php
/**
 * Fileupload
 *
 * ファイルアップロードに必要な処理
 *
 * @author Masanori Oobayashi
 */
class Fileupload
{

    public static function is_file()
    {
        return empty($_FILES);
    }


    // オリジナルファイルの保存
    public static function create_original($image, $save_path)
    {
        $config    = Config::get('config_app.images');
        $save_path = preg_replace('/\/$/', '', $save_path).'/';

        self::resize($image['saved_as'], $image['saved_to'], $save_path, $config['max_width']);
    }



    // サムネイルの作成
    public static function create_thumbnail($image, $save_path)
    {
        $config    = Config::get('config_app.images.thumbnail');
        $save_path = preg_replace('/\/$/', '', $save_path).'/';

        self::resize($image['saved_as'], $image['saved_to'], $save_path, $config['max_width']);
    }



    // リサイズの実行
    // $file ファイル名
    // $file_path ファイルが保存されているディレクトリ
    // $save_path 保存先
    // $width 横幅
    protected static function resize($file, $file_path, $save_path, $width=100)
    {
        // ファイルのロード
        $instance = Image::forge();
        $instance->load($file_path.$file);

        $sizes = $instance->sizes();

        // 保存先の確認
        if ( ! is_dir($save_path))
        {
            self::create_save_directory($save_path);
        }

        if ($sizes->width > $width)
        {
            $height = ($sizes->height/$sizes->width)*$width;

            $instance->resize($width, $height);


            $instance->save($save_path.$file);
        }
        else
        {
            File::copy($file_path.$file, $save_path.$file);
        }

    }

    // 保存先の作成
    protected static function create_save_directory($path)
    {
        $path = preg_replace('/\/$/', '', $path);
        $str  = '';
        $tmp  = explode('/', $path);

        for ($i = 1; $i < count($tmp); $i++)
        {
            if ($i < count($tmp)-1)
            {
                $str .= '/'.$tmp[$i];
            }
            $last = $tmp[$i];
        }

        File::create_dir($str, $last);
    }
}