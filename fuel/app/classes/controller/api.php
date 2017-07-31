<?php
class Controller_Api extends Controller_Rest
{
    /**
     * mapsgeodata geojson 形式のデータ出力（一覧）
     *
     * @access public
     * @return void
     */
    public function action_mapsgeodata()
    {
        $geojson = [
            'type'     => 'FeatureCollection',
            'features' => [],
        ];

        // データの取得
        $points = Model_Point::find('all', [
            'where' => [['is_open', true]],
            'related' => [
                'icon',
                'icons',
                'images',
            ],
        ]);

        // 結果の展開
        foreach ($points as $point)
        {
            $tag         = [];
            $image       = '';

            foreach ($point->icons as $icon)
            {
                $tag[] = $icon->name;
            }

            // 先頭画像を取得
            if (count($point->images) > 0)
            {
                foreach ($point->images as $_image)
                {
                    $head = array_shift($point->images);
                    if ($head->is_open)
                    {
                        break;
                    }
                }

                $image = Config::get('config_app.filepath.point').'/thumbnail/'.$head->file;
            }

            array_push($geojson['features'], [
                'type' => 'Feature',
                'geometry' => [
                   'type'        => 'Point',
                   'coordinates' => [$point->longitude, $point->latitude],
                ],
                'properties'=>  [
                    'time'   => date('Y.m.d.H:i', strtotime($point->happened_at)),
                    'title'  => $point->name,
                    'area'   => '',
                    'tag'    => $tag,
                    'detail' => 'map/detail/'.$point->id,
                    'thumb'  => $image,
                    'icon'   => [
                        'iconUrl' => Config::get('config_app.filepath.icon').'/'.$point->icon->file,
                    ]
                ]
            ]);
        }

        return $this->response($geojson);
    }


    public function action_demomaps()
    {
        $geojson = [
            'type'     => 'FeatureCollection',
            'features' => [],
        ];

        // デモ用データ
        // 本来は外部 URL へデータを取得しにいく
        Config::load('demo_data.json');

        // 結果の展開
        foreach (Config::get('data') as $data)
        {
            array_push($geojson['features'], [
                'type' => 'Feature',
                'geometry' => [
                   'type'        => 'Point',
                   'coordinates' => [$data['geometry']['coordinates']['0'], $data['geometry']['coordinates']['1']]
                ],
                'properties'=>  [
                    'time'   => $data['properties']['time'],
                    'title'  => $data['properties']['title'],
                    'area'   => $data['properties']['area'],
                    'tag'    => $data['properties']['tag'],
                    'detail' => $data['properties']['detail'],
                    'thumb'  => $data['properties']['thumb'],
                    'icon'   => [
                        'iconUrl' => $data['properties']['icon']['iconUrl'],
                    ]
                ]
            ]);
        }

        return $this->response($geojson);
    }

    /**
     * action_mapdetail geojson 形式のデータ出力（地図詳細）
     *
     * @access public
     * @return void
     */
    public function action_mapdetail($id)
    {
        $geojson = [
            'type'     => 'FeatureCollection',
            'features' => [],
        ];

        $image = '';
        $tag   = [];

        $point = Model_Point::find($id, [
            'related' => [
                'icon',
                'icons',
                'images',
            ],
        ]);

        foreach ($point->icons as $icon)
        {
            $tag[] = $icon->name;
        }

        // 先頭画像を取得
        if (count($point->images) > 0)
        {
            foreach ($point->images as $_image)
            {
                $head = array_shift($point->images);
                if ($head->is_open)
                {
                    break;
                }
            }

            $image = Config::get('config_app.filepath.point').'/thumbnail/'.$head->file;
        }

        $_point = [
            'type' => 'Feature',
            'geometry' => [
               'type'        => 'Point',
               'coordinates' => [$point->longitude, $point->latitude],
            ],
            'properties'=>  [
                'time'   => date('Y.m.d.H:i', strtotime($point->happened_at)),
                'title'  => $point->name,
                'area'   => '',
                'tag'    => $tag,
                'detail' => 'map/detail/'.$point->id,
                'thumb'  => $image,
                'icon'   => [
                    'iconUrl' => Config::get('config_app.filepath.icon').'/'.$point->icon->file,
                ]
            ]
        ];

        array_push($geojson['features'], $_point);

        return $this->response($geojson);

    }

}