<?
class Controller_Map extends Controller_Template
{
    /**
     * map
     *
     * @access  public
     * @return  Response
     */
    public function action_index()
    {
        // 大学の読み込み
        $universities = Model_University::find('all', [
            'order_by' => [
                'sort' => 'asc',
            ],
        ]);

        // 設定の読み込み
        $this->template->set_global('universities', $universities);
        $this->template->set_global('map_types',   Config::get('config_app.map_types'));

        $this->template->set_global('css', 'map.css');
        $this->template->set_global('js', ['leaflet-0.7.7.js', 'map-plugin.js', 'map_setting.js']);

        $this->template->content = View::forge('map/index');
    }


    /**
     * action_detail 詳細
     *
     * @access  public
     * @return  Response
     */
    public function action_detail($id=null)
    {
        is_null($id) and Response::redirect('map');

        $point = Model_Point::find($id, [
            'where' => [['is_open', true]],
            'related' => [
                'icons',
                'images',
            ],
        ]);

        if (count($point) > 0)
        {
            $this->template->set_global('point', $point);
            $this->template->set_global('filepath_icon', Config::get('config_app.filepath.icon'));
            $this->template->set_global('filepath_image', Config::get('config_app.filepath.point'));

            $this->template->set_global('css', 'map.css');
            $this->template->set_global('js', [
                'leaflet-0.7.7.js',
                'map-plugin.js',
                'plugin/imagelightbox.min.js',
                'plugin/imagelightbox-option.js',
                // 'movie.js',
                'detail_map.js'
            ]);

            $this->template->content = View::forge('map/detail');
        }
        else
        {
            Response::redirect('map');
        }
    }


    /**
     * action_streetview
     *
     * @access  public
     * @return  Response
     */
    public function action_streetview($id=null)
    {
        is_null($id) and Response::redirect('map');

        $point = Model_Point::find($id, [
            'where' => [['is_open', true]],
        ]);

        if (count($point) > 0)
        {
            // 設定の読み込み
            $this->template->set_global('point', $point);
            $this->template->set_global('js', [
                'leaflet-0.7.7.js',
                'map-plugin.js',
                'street_view.js',
            ]);

            $this->template->content = View::forge('map/streetview');
        }
        else
        {
            Response::redirect('map');
        }

    }

}
