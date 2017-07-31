<?php
/**
 * Validation
 *
 * バリデーションの拡張（ルール）
 *
 */
class Validation extends Fuel\Core\Validation
{
    protected function _construct($fieldset)
    {
        parent::_construct($fieldset);
    }


    /**
     * _validation_registkey_check 認証キーチェック
     *
     * @param string $val
     * @access public
     * @return bool
     */
    public static function _validation_registkey_check($val, $expire = false)
    {
        // 存在チェック
        if ( ! $temp = Model_Crud_Registkey::find_one_by_key($val))
        {
            return false ;
        }

        // 有効期限チェック
        if ($expire)
        {
            return time() <= $temp->limited_at;
        }

        return true;
    }


    /**
     * _validation_unique 重複チェック
     *
     * @param string $val
     * @param string $options
     * @access public
     * @return bool
     */
    public static function _validation_unique($val, $options)
    {
        list($table, $field) = explode('.', $options);

        $result = DB::select(DB::expr("LOWER (\"$field\")"))
            ->where($field, '=', Str::lower($val))
            ->from($table)
            ->execute();

        return ! ($result->count() > 0);
    }

    /**
     * _validation_hiragana ひらがなのバリデーション（ブランクを許容）
     *
     * @param string $str
     * @access public
     * @return bool
     */
    public static function _validation_hiragana($str)
    {
        return (bool) preg_match('/^[ぁ-ゞ 　〜ー−]+$/u', $str);
    }

    /**
     * _validation_katakana カタカナのバリデーション（ブランクを許容）
     *
     * @param string $str
     * @access public
     * @return bool
     */
    public static function _validation_katakana($str)
    {
        return (bool) preg_match('/^[ァ-ヾ 　〜ー−]+$/u', $str);
    }

    /**
     * _validation_year_month 年月
     *
     * @param string $str
     * @static
     * @access public
     * @author Masanori Oobayashi
     * @return void
     */
    public static function _validation_year_month($str)
    {
        return (bool) preg_match('/(^$|(19|20|21)[0-9]{2}-[0-9]{1,2})/', $str);
    }

    /**
     * _validation_valid_ymd YYYY-MM-DD の形式かをチェック
     *
     * @param string $str
     * @access public
     * @return void
     */
    public static function _validation_valid_ymd($str)
    {
        return (bool) preg_match('/(^$|(19|20|21)[0-9]{2}-[0-1][0-9]-[0-3][0-9])/', $str);
    }

    /**
     * 値の正当性チェック
     *
     * @param string $val
     * @param string $options
     * @static
     * @access public
     * @return boolean
     */
    public static function _validation_valid_array_val($val, $options)
    {
        if ($val) {
            if ( ! is_array($val)) {
                return false;
            }
            foreach ($val as $v) {
                if ( ! array_key_exists($v, $options)) return false;
            }
        }
        return true;
    }

    /**
     * _validation_complex_required_with 複合バリデーションの必須チェック
     *
     * 対象の $field の値が $value のとき、必須判定を行う
     *
     * @param string $val
     * @param string $field
     * @param string $value
     * @access public
     * @return void
     */
    public function _validation_complex_required_with($val, $field, $value)
    {
        if (
              ! $this->_empty($this->input($field))
            and ($this->_empty($val) || $val === '0')
            and $this->input($field) == $value
        )
        {
            $validating = $this->active_field();
            throw new \Validation_Error($validating, $val, array('complex_required_with' => array($this->field($field))), array($this->field($field)->label));
        }

        return true;
    }


    /**
     * _validation_user_duplication ユーザーの登録重複チェック
     *
     * @param string $val
     * @access public
     * @return void
     */
    public function _validation_user_duplication($val)
    {
        $username_count = Model_User::query()->where('username', $val)->count();
        $email_count    = Model_User::query()->where('email',    $val)->count();

        return ($email_count > 0 || $username_count > 0) ? false : true ;
    }


    /**
     * _validation_valid_keitai_email
     *
     * 通常は携帯電話アドレスがあると FALSE を返す
     * $type が false のときは携帯電話アドレスのとき TRUE を返す
     *
     * @param string $val
     * @param bool   $type
     * @access public
     * @return void
     */
    public function _validation_valid_keitai_email($val, $type=true)
    {
        $result = true;

        $domains = [
            'docomo.ne.jp',
            'mopera.net',
            'softbank.ne.jp',
            'vodafone.ne.jp',
            'disney.ne.jp',
            'i.softbank.jp',
            'ezweb.ne.jp',
            'biz.ezweb.ne.jp',
            'augps.ezweb.ne.jp',
            'ido.ne.jp',
            'emnet.ne.jp',
            'emobile.ne.jp',
            'emobile-s.ne.jp',
            'ymobile1.ne.jp',
            'ymobile.ne.jp',
            'pdx.ne.jp',
            'willcom.com',
            'wcm.ne.jp',
            'y-mobile.ne.jp',
        ];

        foreach ($domains as $d)
        {
            $res = preg_match('/.*@.*'.$d.'$/', $val);
            (bool) $res and $result = false;
        }

        return ($type) ? $result : ! $result;
    }
}

