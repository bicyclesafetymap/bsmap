<?
class Controller_Help extends Controller_Template
{
    /**
     * action_index ヘルプ表示
     *
     * @access  public
     * @return  void
     */
    public function action_index()
    {
        // 設定の読み込み
        $this->template->set_global('js', ['help.js']);

        $this->template->content = View::forge('help/index');
    }


    /**
     * action_icon アイコン一覧の表示
     *
     * @access  public
     * @return  void
     */
    public function action_icon()
    {
        $data['icons'] = Model_Icon::find('all', [
            'order_by' => ['id' => 'desc'],
        ]);

        $this->template->set_global('filepath' , Config::get('config_app.filepath.icon'));
        $this->template->content = View::forge('help/icon', $data);
    }
}
