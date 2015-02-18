# Yii2 Yandex Maps Components #

* * *

This repo is the fork of the [yii2-yandex-maps](https://github.com/Mirocow/yii2-yandex-maps "yii2-yandex-maps")
by [Mirocow](https://github.com/Mirocow "Mirocow")

* * *

## Components ##

- [`katzz0\yandexmaps\Api`](https://github.com/katzz0/yii2-yandex-maps#katzz0yandexmapsapi)
- [`katzz0\yandexmaps\Map`](https://github.com/katzz0/yii2-yandex-maps#katzz0yandexmapsmap)
- [`katzz0\yandexmaps\Canvas`](https://github.com/katzz0/yii2-yandex-maps#katzz0yandexmapscanvas)
- `katzz0\yandexmaps\JavaScript`
- `katzz0\yandexmaps\Placemark`
- `katzz0\yandexmaps\Polyline`
- TODO: [Geo XML](http://api.yandex.ru/maps/doc/jsapi/2.1/dg/concepts/geoxml.xml)
- TODO: [GeoObject](http://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/GeoObject.xml)
- TODO: [Balloon](http://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/Balloon.xml)
- TODO: [Hint](http://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/Hint.xml)
- TODO: [Clusterer](http://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/Clusterer.xml)

### katzz0\yandexmaps\Api ###

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

### katzz0\yandexmaps\Map ###

Map instance.

__Usage__

```php
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

### katzz0\yandexmaps\Canvas ###

This is widget which render html tag for your map.

__Usage__

Simple add widget to view:
```php

use katzz0\yandexmaps\Canvas as YandexMaps;

echo Canvas::widget([
        'htmlOptions' => [
            'style' => 'height: 400px;',
        ],
        'map' => $map,
    ]);
```

### katzz0\yandexmaps\Clusterer ###

```js
    for (var i in map_point) {
    points[i] = new ymaps.GeoObject({
     geometry : {
      type: 'Point',
      coordinates : [map_point[i]['lat'],map_point[i]['lng']]
     },
     properties : {
      balloonContentBody : map_point[i]['body']
      // hintContent : 'подробнее'
     }
    },
    {
     iconImageHref: '/i/' + map_point[i]['spec']+'.png',
     iconImageSize: [29,29],
     balloonIconImageHref: '/i/' + map_point[i]['spec']+'.png',
     balloonIconImageSize: [29,29],
     hasBalloon: true
    });
   }

   var clusterer = new ymaps.Clusterer();
   clusterer.add(points);
   map.geoObjects.add(clusterer);
```
