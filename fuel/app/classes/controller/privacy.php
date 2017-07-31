<?
class Controller_Privacy extends Controller_Template
{
    /**
     * map
     *
     * @access  public
     * @return  Response
     */
    public function action_index()
    {
        // 設定の読み込み
        // $this->template->set_global('univ_places', Config::get('config_app.univ_places'));
        // $this->template->set_global('map_types',   Config::get('config_app.map_types'));

        // $this->template->set_global('css', 'map.css');
        // $this->template->set_global('js', ['help.js']);

        $this->template->content = View::forge('privacy/index');
    }
}

