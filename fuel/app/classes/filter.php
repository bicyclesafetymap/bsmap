<?php
/**
 * Filter
 *
 * バリデーションの拡張（バリデーション前に通すフィルタ）
 *
 * @author Masanori Oobayashi
 */
class Filter
{ 
    /**
     * conv_kana カタカナに変換する
     * 
     * @param string $val
     * @access public
     * @return string
     */
    public static function conv_kana($val)
    {
        // エラー処理
        if($val == '') return '';
        if( ! function_exists('mb_convert_kana')) return FALSE;

        // 処理
        return mb_convert_kana($val, 'KVC', Config::get('encoding'));
    }


    /**
     * conv_onebyte 全角を半角に変換する（英数字のみ）
     *
     * @param string $val
     * @access public
     * @return string
     */
    public static function conv_onebyte($val)
    {
        // エラー処理
        if($val == '') return '';
        if( ! function_exists('mb_convert_kana')) return FALSE ;

        // 処理
        return mb_convert_kana($val, 'a', Config::get('encoding'));
    }


    /**
     * conv_kanji_num 漢数字を半角英数字に変換する
     *
     * @param string $str
     * @access public
     * @return string
     */
    public static function conv_kanji_num($str)
    {
        // 漢字
        $str = str_replace('〇', '0', $str);
        $str = str_replace('一', '1', $str);
        $str = str_replace('二', '2', $str);
        $str = str_replace('三', '3', $str);
        $str = str_replace('四', '4', $str);
        $str = str_replace('五', '5', $str);
        $str = str_replace('六', '6', $str);
        $str = str_replace('七', '7', $str);
        $str = str_replace('八', '8', $str);
        $str = str_replace('九', '9', $str);

        // 特殊文字
        $str = str_replace('①', '1', $str);
        $str = str_replace('②', '2', $str);
        $str = str_replace('③', '3', $str);
        $str = str_replace('④', '4', $str);
        $str = str_replace('⑤', '5', $str);
        $str = str_replace('⑥', '6', $str);
        $str = str_replace('⑦', '7', $str);
        $str = str_replace('⑧', '8', $str);
        $str = str_replace('⑨', '9', $str);
    
        return $str ;
    }


    /**
     * remove_hyphen ハイフンの削除
     *
     * @param string $str
     * @access public
     * @return string
     */
    public static function remove_hyphen($str)
    {
        $hyphens = array('-', '一', 'ー', '−');
    
        return str_replace($hyphens, '', $str);
    }


    /**
     * remove_space 空白の削除
     *
     * @param string $str
     * @access public
     * @return string
     */
    public static function remove_space($str)
    {
        return str_replace(array(' ','　'), '', $str);
    }


    /**
     * add_zero_for_month YYYY-MM の形式に整形
     * 
     * @param string $str 
     * @access public
     * @return void
     */
    public static function add_zero_for_month($str)
    {
        $str = preg_replace('/([0-9]{4})([0-9]{1,2})/', '$1-$2', $str);
        return preg_replace('/-([0-9])$/', '-0$1', $str);
    }


    /**
     * add_zero_for_ymg YYYY-MM-DD の形にする
     * 
     * @param string $str 
     * @access public
     * @return void
     */
    public static function add_zero_for_ymg($str)
    {
        $str = preg_replace('/^([0-9]{4})([0-9]{2})([0-9]{1,2})/', '$1-$2-$3', $str);
        return preg_replace('/-([0-9])$/', '-0$1', $str);
    }


    /**
     * remove_primary_school 小学校の文字を消す
     * 
     * @param string $str 
     * @access public
     * @return void
     */
    public static function remove_primary_school($str)
    {
        return str_replace(array('小学校', 'しょうがっこう'), '', $str);
    }


    /**
     * delete_expired_registkey 有効期限の切れたレジストキーを削除する
     * 
     * @param string $str 
     * @param string $option table.field の形で記述 
     * @access public
     * @return void
     */
    public static function delete_expired_registkey($str, $options)
    {
        list($table, $field) = explode('.', $options);

        // 存在チェック
        if ($temp = Model_Registkey::find('all', ['where' => [['email', $str]]]))
        {
            // 有効期限チェック
            foreach ($temp as $key)
            {
                if ($key->limited_at < Date::forge()->get_timestamp())
                {
                    $key->delete();
                }
            }
        }

        return $str;
    }
}

