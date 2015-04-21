# Yii2 Yandex Maps Components #

* * *

This repo is the fork of the [yii2-yandex-maps](https://github.com/Mirocow/yii2-yandex-maps "yii2-yandex-maps")
by [Mirocow](https://github.com/Mirocow "Mirocow")

* * *

## Components ##

- [`webmikez\yandexmaps\Api`](https://github.com/katzz0/yii2-yandex-maps#katzz0yandexmapsapi)
- [`webmikez\yandexmaps\Map`](https://github.com/katzz0/yii2-yandex-maps#katzz0yandexmapsmap)
- [`webmikez\yandexmaps\Canvas`](https://github.com/katzz0/yii2-yandex-maps#katzz0yandexmapscanvas)
- `webmikez\yandexmaps\JavaScript`
- `webmikez\yandexmaps\Placemark`
- `webmikez\yandexmaps\Polyline`
- TODO: [Geo XML](http://api.yandex.ru/maps/doc/jsapi/2.1/dg/concepts/geoxml.xml)
- TODO: [GeoObject](http://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/GeoObject.xml)
- TODO: [Balloon](http://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/Balloon.xml)
- TODO: [Hint](http://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/Hint.xml)
- TODO: [Clusterer](http://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/Clusterer.xml)

### webmikez\yandexmaps\Api ###

Application components which register scripts.

__Usage__

Attach component to application (e.g. edit config/main.php):
```php
'components' => [
	'yandexMapsApi' => [
		'class' => 'mirocow\yandexmaps\Api',
	]
 ],
```

### webmikez\yandexmaps\Map ###

Map instance.

__Usage__

```php
use webmikez\yandexmaps\Map;

$map = new Map('yandex_map', [
        'center' => [55.7372, 37.6066],
        'zoom' => 10,
        // Enable zoom with mouse scroll
        'behaviors' => array('default', 'scrollZoom'),
        'type' => "yandex#map",
    ],
    [
        // Permit zoom only fro 9 to 11
        'minZoom' => 9,
        'maxZoom' => 11,
        'controls' => [
          "new ymaps.control.SmallZoomControl()",
          "new ymaps.control.TypeSelector(['yandex#map', 'yandex#satellite'])",
        ],
    ]
);
```

### webmikez\yandexmaps\Canvas ###

This is widget which render html tag for your map.

__Usage__

Simple add widget to view:
```php
use webmikez\yandexmaps\Canvas as YandexMaps;

<?= YandexMaps::widget([
    'htmlOptions' => [
        'style' => 'height: 600px;',
    ],
    'map' => new Map('yandex_map', [
        'center' => [55.7372, 37.6066],
        'zoom' => 17,
        'controls' => [Map::CONTROL_ZOOM],
        'behaviors' => [Map::BEHAVIOR_DRAG],
        'type' => "yandex#map",
    ],
    [
        'objects' => [new Placemark(new Point(55.7372, 37.6066), [], [
            'draggable' => true,
            'preset' => 'islands#dotIcon',
            'iconColor' => '#2E9BB9',
            'events' => [
                'dragend' => 'js:function (e) {
                    console.log(e.get(\'target\').geometry.getCoordinates());
                }'
            ]
        ])]
    ])
]) ?>

```

You can use also direct place label:
```php
<?= YandexMaps::widget([
    'htmlOptions' => [
        'style' => 'height: 600px;',
    ],
    'map' => new Map(null, [
        'center' => 'London',
        'zoom' => 17,
        'controls' => [Map::CONTROL_ZOOM],
        'behaviors' => [Map::BEHAVIOR_DRAG],
        'type' => "yandex#map",
    ],
    [
        'objects' => [new Placemark(null, [], [
            'draggable' => true,
            'preset' => 'islands#dotIcon',
            'iconColor' => '#2E9BB9',
            'events' => [
                'dragend' => 'js:function (e) {
                    console.log(e.get(\'target\').geometry.getCoordinates());
                    }'
            ]
        ])]
    ])
]) ?>

```