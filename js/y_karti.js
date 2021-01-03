// Функция ymaps.ready() будет вызвана, когда
// загрузятся все компоненты API, а также когда будет готово DOM-дерево.
ymaps.ready(init);
var obj_map = {};

function init() {
// массив где будем хранить геообъекты - точка из координат которых будем делать многоугольник
obj_map.massiv_geoObject = massiv_geoObject = [];
// переменная в которой будет храниться объект карта
mm = null;
ind = 1    

ymaps.geolocation.get()
.then(
    (rez) => rez.geoObjects.position || [55.76, 37.64]
)
.then((cor) => {
    // Создание карты.
    obj_map.mm = mm = new ymaps.Map(
        "map",
        {
            center: cor,
            zoom: 9,
            controls: ['fullscreenControl', 'geolocationControl', 'searchControl', 'typeSelector', 'zoomControl'],
            type: 'yandex#hybrid'

        },
        {
            searchControlProvider: 'yandex#search'
        }
    );

    btn_fix = new ymaps.control.Button({
        data: {
            content: 'зафиксировать участок'
        },
        options: {
            maxWidth: 350,
            selectOnClick: false
        }
        
    });
    btn_fix.events.add('click', (oe) => { 
        ficsaciy_uchastka(oe, massiv_geoObject)
     })
    
    

    // 1 - sozdanie_tochki_po_cliku - создаём точку на карте по клику на карте
    function sozdanie_tochki_po_cliku(oe) {
        // получаем координаты клика
        var coord_click = oe.get('coords');
        // создаём точку по полученной координате
        var tochka = new ymaps.GeoObject(
            {
                geometry: {
                    type: "Point",
                    coordinates: coord_click,
                
                },
                properties: {
                    balloonContent: '<h3 class="qw">привет! </h3><p>продолжай кликать на карте и отмечай участок</p><p>Для соединения последней точки с первой появится кнопка, которая зафиксирует ваш участок</p>',
                    iconContent : ind++
                }
            },
            {
                draggable: true,
                openEmptyBalloon: true,
                // balloonCloseButton: false
            }
            
        );
        // сохраняем координаты в массиве координат
        tochka.tip = "Point";
        tochka.coord = coord_click;
        massiv_geoObject.push(tochka);
        if (ind == 4) {
            mm.controls.add(btn_fix);
        }
        mm.geoObjects.add(tochka);
        sozdanie_linii_mejdu_tochkami(massiv_geoObject)
    }

    // 2 - sozdanie_linii_mejdu_tochkami - создаёт линию между точками, массив точек передаётся в аргументе
    function sozdanie_linii_mejdu_tochkami(array_coord) {
        if (array_coord.length < 2) return
        var kol_obj = array_coord.length;
        var liniy = new ymaps.GeoObject(
            {
                geometry: {
                    type: "LineString",
                    coordinates: [
                        array_coord[kol_obj - 2].coord,
                        array_coord[kol_obj - 1].coord 
                    ]
                }
            },
            {
                draggable: true
            }
        );
        // console.log(liniy.geometry._coordPath._coordinates);
        // console.log(typeof liniy);
        // massiv_geoObject.push(liniy);
        mm.geoObjects.add(liniy);
        
    }
    // 3 - ficsaciy_uchastka - фиксирует участок путём соединения линией последней и первой точки
    function ficsaciy_uchastka(oe, array_coord) {
        var liniy = new ymaps.GeoObject(
            {
                geometry: {
                    type: "LineString",
                    coordinates: [
                        array_coord[0].coord,
                        array_coord[array_coord.length - 1].coord
                    ]
                }
            },
            {
                draggable: true
            }
        );
        mm.geoObjects.add(liniy);
        setTimeout(
            function () {
                sozdanie_polygona_iz_coord(massiv_geoObject)
            },
            1000
            
        )
    }

    // 4 - sozdanie_polygona_iz_coord - создаёт полигон из координат точек
    function sozdanie_polygona_iz_coord(array_coord) {
        coord = [];
        for (var i = 0; i < array_coord.length; i++){
            coord.push(array_coord[i].coord);
        }
        mm.geoObjects.removeAll();
        polygon = new ymaps.GeoObject({
            geometry: {
                type: "Polygon",
                coordinates: [ coord, []]
            }
        });
        
        mm.geoObjects.add(polygon);
    }

    // навешиваем события на карту
    mm.events.add('click', function (oe) {
        sozdanie_tochki_po_cliku(oe)
    })
})
}