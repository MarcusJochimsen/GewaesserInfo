<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $water->name }} - {{ $water->location }}</title>

    <link href="{{ asset('css/print/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/print/paper.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script src="{{ asset('js/print/jquery.js') }}" type="application/javascript"></script>
    {{--    <script src="{{ asset('js/print/popper.js') }}"></script>--}}
    <script src="{{ asset('js/print/bootstrap.js') }}" type="application/javascript"></script>
    <script src="{{ asset('js/app.js') }}" type="application/javascript"></script>

    <script type="application/javascript">
        let googleMapsRoute = new GoogleMaps('{{ env('GOOGLE_MAPS_API') }}', 'map_route');
        let googleMapsDriveways = new GoogleMaps('{{ env('GOOGLE_MAPS_API') }}', 'map_driveways');
        let googleMapsRoadmap = new GoogleMaps('{{ env('GOOGLE_MAPS_API') }}', 'map_roadmap');
        let googleMapsSatellite = new GoogleMaps('{{ env('GOOGLE_MAPS_API') }}', 'map_satellite');
        let googleMapsDangers = new GoogleMaps('{{ env('GOOGLE_MAPS_API') }}', 'map_dangers');

        function initMap() {
            {{--googleMaps.initPrintWater('{{ $waterObj }}', '{{ $drivewaysObj }}', '{{ $dangersObj }}');--}}

            let zoom = 11;
            let center = new google.maps.LatLng(parseFloat('{{ $water->center_lat }}'), parseFloat('{{ $water->center_lng }}'));
            let home = new google.maps.LatLng(53.33127, 9.89499);


            googleMapsRoute.initMap(center, zoom, true);
            new google.maps.Marker({
                position: center,
                map: googleMapsRoute.map,
                label: {
                    fontFamily: "'Font Awesome 5 Free'",
                    text: '\uf773',
                    fontWeight: '900',
                    fontSize: '16px',
                    color: '#610f0d',
                },
            });
            new google.maps.Marker({
                position: home,
                map: googleMapsRoute.map,
                label: {
                    fontFamily: "'Font Awesome 5 Free'",
                    text: '\uf015',
                    fontWeight: '900',
                    fontSize: '16px',
                    color: '#610f0d',
                },
            });
            let bounds = new google.maps.LatLngBounds();
            bounds.extend(center);
            bounds.extend(home);
            googleMapsRoute.map.fitBounds(bounds);


            googleMapsDriveways.initMap(center, zoom, true);
            googleMapsDriveways.setIndexMetaMarker('{{ route('driveway.markers', ['water' => $water->id]) }}', '{{ route('driveway.show', ['water' => $water->id, 'driveway' => 'replaceMe']) }}', '{{ $water->bounds }}', 'driveway');
            googleMapsDriveways.map.setZoom(googleMapsDriveways.map.getZoom()+1);


            googleMapsRoadmap.initMap(center, zoom, true);
            googleMapsRoadmap.map.fitBounds(googleMapsRoadmap.getJSON('{{ $water->bounds }}'));
            googleMapsRoadmap.map.setMapTypeId('OSM');
            googleMapsRoadmap.map.mapTypes.set("OSM", new google.maps.ImageMapType({
                getTileUrl: function(coord, zoom) {
                    // "Wrap" x (longitude) at 180th meridian properly
                    // NB: Don't touch coord.x: because coord param is by reference, and changing its x property breaks something in Google's lib
                    var tilesPerGlobe = 1 << zoom;
                    var x = coord.x % tilesPerGlobe;
                    if (x < 0) {
                        x = tilesPerGlobe+x;
                    }
                    // Wrap y (latitude) in a like manner if you want to enable vertical infinite scrolling

                    return "https://tile.openstreetmap.org/" + zoom + "/" + x + "/" + coord.y + ".png";
                },
                tileSize: new google.maps.Size(256, 256),
                name: "OpenStreetMap",
                maxZoom: 18
            }));


            googleMapsSatellite.initMap(center, zoom, true);
            googleMapsSatellite.map.fitBounds(googleMapsSatellite.getJSON('{{ $water->bounds }}'));
            googleMapsSatellite.map.setMapTypeId('satellite');


            googleMapsDangers.initMap(center, zoom, true);
            googleMapsDangers.setIndexMetaMarker('{{ route('danger.markers', ['water' => $water->id]) }}', '{{ route('danger.show', ['water' => $water->id, 'danger' => 'replaceMe']) }}', '{{ $water->bounds }}', 'danger');
        }

        $(document).ready(function () {
            if ('{{ $water->current->label }}' === 'stehend') {
                $('#fliessV-container').addClass('d-none');
            }

            ellipsizeTextBox('textarea_description');
            ellipsizeTextBox('textarea_dangertext');
            ellipsizeTextBox('textarea_contact');

            {{--let map = new OpenLayers.Map("map_roadmap");--}}
            {{--var fromProjection = new OpenLayers.Projection("EPSG:4326");   // Transform from WGS 1984--}}
            {{--var toProjection   = new OpenLayers.Projection("EPSG:900913"); // to Spherical Mercator Projection--}}
            {{--map.addLayer(new OpenLayers.Layer.OSM());--}}
            {{--map.setCenter(new OpenLayers.LonLat(parseFloat({{ $water->lng }}),parseFloat({{ $water->lat }})).transform( fromProjection, toProjection), 15 );--}}

            {{--map = new OpenLayers.Map("map_roadmap");--}}
            {{--var mapnik = new OpenLayers.Layer.OSM();--}}
            {{--map.addLayer(mapnik);--}}
            {{--map.setCenter(new OpenLayers.LonLat('{{ $water->center_lng }}','{{ $water->center_lat }}') // Center of the map--}}
            {{--    .transform(--}}
            {{--        new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984--}}
            {{--        new OpenLayers.Projection("EPSG:900913") // to Spherical Mercator Projection--}}
            {{--    ), 15 // Zoom level--}}
            {{--);--}}
        });

        function ellipsizeTextBox(id) {
            var el = document.getElementById(id);
            var wordArray = el.innerHTML.split(' ');
            while(el.scrollHeight > el.offsetHeight) {
                wordArray.pop();
                el.innerHTML = wordArray.join(' ') + ' ...';
            }
        }
    </script>

    <style>
        @page {
            size: A3 landscape
        }

        .front_side {
            padding: 10mm 10mm 10mm 20mm;
        }

        .back_side {
            padding: 10mm 20mm 10mm 10mm;
        }

        .half_side {
            width: 195mm;
            height: 276mm;
        }

        .half_side.left {
            padding-right: 10mm;
        }

        .half_side.right {
            padding-left: 10mm;
            margin-top: -10mm;
        }

        .note_block {
            height: 274mm;
        }

        .card-headline {
            width: max-content;
            padding: 2mm;
            background-color: #ffffff;
            border-radius: 2mm;
            position: relative;
            left: 8mm;
            top: 5mm;
            z-index: 2;
        }

        .card-headline h4 {
            padding: 0;
            margin: 0;
        }

        .card.infobox {
            height: 225mm;
        }

        .map .full-width {
            width: 100%;
        }

        #map_route, #map_driveways {
            height: 105mm;
        }

        #map_roadmap, #map_satellite, #map_dangers {
            /*height: 86.5mm;*/
            height: 82mm;
        }

        .update {
            font-style: italic;
            font-size: 70%;
        }

        .textarea {
            height: 42mm;
            overflow:hidden;
            text-overflow: ellipsis;
        }

        #hole_puncher {
            position: absolute;
            top: 148mm;
            left: 0;
            width: 5mm;
            height: 0;
            border-top: 0.5mm solid #000000;
        }

        #foldline {
            position: absolute;
            left: 205mm;
            width: 0;
            height: 5mm;
            border-left: 0.5mm solid #000000;
        }

        #foldline.top {
            top: 0;
        }

        #foldline.bottom {
            bottom: 0;
        }



        /* Bootstrap */
        .card {
            border-color: #000000;
            overflow: hidden;
        }
    </style>
</head>
<body class="A3 landscape">
<div class="sheet front_side d-flex">
    <span id="hole_puncher"></span>
    <div class="half_side left">
        <div class="card">
            <div class="card-body d-flex justify-content-between">
                <span>
                    <img src="{{ asset('images/gewaesserinfo.svg') }}" alt="GewaesserInfo.de Logo" width="100" height="100">
                    <img src="https://chart.apis.google.com/chart?chs=100x100&cht=qr&chld=L&chl={{ route('water.show', ['water' => $water->id]) }}" alt="QR-Code mit Link zum Gewässer">
                </span>
                <span class="text-right">
                    <h3>{{ $water->name }} <br><small>in {{ $water->location }}</small></h3>
                    <span class="update">Stand: {{ Carbon\Carbon::now()->formatLocalized('%d %B %Y') }}</span>
                </span>
            </div>
        </div>
        <div class="card-headline map">
            <h4>Informationen</h4>
        </div>
        <div class="card infobox">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_content">
                                <div class="row pt-3 mb-2">
                                    <div class="col-12">
                                        <p class="text-left"><strong>Beschreibung</strong></p>
                                    </div>
                                    <div class="col-12">
                                        <p class="col-12 textarea" id="textarea_description">{{ $water->description }}</p>
                                    </div>
                                </div>

                                <div class="row pt-3 mb-2">
                                    <div class="col-12">
                                        <p class="text-left"><strong>Gefahren</strong></p>
                                    </div>
                                    <div class="col-12">
                                        <p class="col-12 textarea" id="textarea_dangertext">{{ $water->dangertext }}</p>
                                    </div>
                                </div>

                                <div class="row pt-3 mb-2">
                                    <div class="col-12">
                                        <p class="text-left"><strong>Ansprechpartner</strong></p>
                                    </div>
                                    <div class="col-12">
                                        <p class="col-12 textarea" id="textarea_contact">{{ $water->contact }}</p>
                                    </div>
                                </div>

                                <div class="row pt-3 mb-2">
                                    <div class="col-4">
                                        <p><strong>Max. Tiefe</strong></p>
                                        <div class="col-12">
                                            <p>{{ $water->deep }} m</p>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <p><strong>Art des Gewässers</strong></p>
                                        <div class="col-12">
                                            <p>{{ $water->current->label }}</p>
                                        </div>
                                    </div>
                                    <div class="col-4" id="fliessV-container">
                                        <p><strong>Max. Fließgeschind.</strong></p>
                                        <div class="col-12">
                                            <p>{{ $water->currentV }} m/s</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="half_side right">
        <div class="card-headline map">
            <h4>Draufsicht</h4>
        </div>
        <div class="card map">
            <div id="map_roadmap" class="full-width"></div>
            <div id="map_satellite" class="full-width"></div>
        </div>
        <div class="card-headline map">
            <h4>Gefahrenstellen</h4>
        </div>
        <div class="card map">
            <div id="map_dangers" class="full-width"></div>
        </div>
    </div>
</div>
<div class="sheet back_side d-flex">
    <span id="foldline" class="top"></span>
    <span id="foldline" class="bottom"></span>
    <div class="half_side left">
        <div class="card">
            <div class="card-body d-flex justify-content-between">
                <span>
                    <img src="{{ asset('images/gewaesserinfo.svg') }}" alt="GewaesserInfo.de Logo" width="100" height="100">
                    <img src="https://chart.apis.google.com/chart?chs=100x100&cht=qr&chld=L&chl={{ route('water.show', ['water' => $water->id]) }}">
                </span>
                <span class="text-right">
                    <h3>{{ $water->name }} <br><small>in {{ $water->location }}</small></h3>
                    <span class="update">Stand: {{ Carbon\Carbon::now()->formatLocalized('%d %B %Y') }}</span>
                </span>
            </div>
        </div>
        <div class="card-headline map">
            <h4>Anfahrt</h4>
        </div>
        <div class="card map">
            <div id="map_route" class="full-width"></div>
        </div>
        <div class="card-headline map">
            <h4>Zufahrten</h4>
        </div>
        <div class="card map">
            <div id="map_driveways" class="full-width"></div>
        </div>
    </div>
    <div class="half_side right">
        <div class="card-headline">
            <h4>Notizen</h4>
        </div>
        <div class="card note_block">
            <div class="card-body d-flex justify-content-end align-items-end">
                <span class="text-right">
                    <h5 class="text-right m-0">GewaesserInfo.de <br><small>Tauchergruppe Florian</small> <br><small>Freiwillige Feuerwehr Buchholz</small></h5>
                </span>
                <img src="{{ asset('images/gewaesserinfo.svg') }}" alt="GewaesserInfo.de Logo" width="80" height="80">
            </div>
        </div>
    </div>
</div>

<script src="http://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API') }}&callback=initMap" async
        defer></script>

</body>
</html>
