<?
class Controller_Howto extends Controller_Template
{
    /**
     * Reaport
     *
     * @access  public
     * @return  Response
     */
    public function action_index()
    {
        // 設定の読み込み
        $this->template->content = View::forge('howto/index');
    }

}
