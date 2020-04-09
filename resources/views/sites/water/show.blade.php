@extends('common.base')

@section('water')
    {{ $water->name }}
@endsection

@section('head')
    <script type="application/javascript">
        let googleMaps = new GoogleMaps('{{ env('GOOGLE_MAPS_API') }}');

        function initMap() {
            googleMaps.initShowWater('{{ $water->center_lat }}', '{{ $water->center_lng }}', '{{ $water->bounds }}');
        }

        $(document).ready(function () {
            if ('{{ $water->current->label }}' === 'stehend') {
                $('#fliessV-container').addClass('d-none');
            }
        });
    </script>
@endsection

@section('bottomScripts')
    <script src="http://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API') }}&callback=initMap" async
            defer></script>
@endsection

@section('main')
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>{{ $water->name }} <small>in {{ $water->location }}</small></h3>
            </div>

            <div class="title_right">
                <div class="col-md-6 col-sm-6 col-xs-12 pull-right top_search d-flex justify-content-end flex-wrap">
                    <div class="btn-group ml-3 mb-3">
                        <a class="btn btn-info" type="button" target="_self" href="{{ route('driveway.index', ['water' => $water->id]) }}" title="Zufahrten"><i class="fas fa-route" aria-hidden="true"></i></a>
                        <a class="btn btn-info" type="button" target="_self" href="{{ route('danger.index', ['water' => $water->id]) }}" title="Gefahrenstellen"><i class="fas fa-exclamation-triangle" aria-hidden="true"></i></a>
                    </div>
                    <div class="btn-group ml-3 mb-3">
                        <a class="btn btn-info" type="button" target="_self" href="{{ route('water.edit', ['water' => $water->id]) }}" title="Bearbeiten"><i class="far fa-edit" aria-hidden="true"></i></a>
                        <a class="btn btn-info" type="button" target="_blank" href="{{ route('water.print', ['water' => $water->id]) }}" title="Drucken"><i class="fas fa-print" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        <div id="map" class="overview-map"></div>

                        <div class="ln_solid"></div>

                        <div class="row pt-3 mb-2">
                            <div class="col-sm-3 col-xs-12">
                                <p class="text-sm-right text-xs-left"><strong>Beschreibung</strong></p>
                            </div>
                            <div class="col-sm-9 col-xs-12">
                                <p class="col-12">{{ $water->description }}</p>
                            </div>
                        </div>

                        <div class="row pt-3 mb-2">
                            <div class="col-sm-3 col-xs-12">
                                <p class="text-sm-right text-xs-left"><strong>Gefahren</strong></p>
                            </div>
                            <div class="col-sm-9 col-xs-12">
                                <p class="col-12">{{ $water->dangertext }}</p>
                            </div>
                        </div>

                        <div class="row pt-3 mb-2">
                            <div class="col-sm-3 col-xs-12">
                                <p class="text-sm-right text-xs-left"><strong>Ansprechpartner</strong></p>
                            </div>
                            <div class="col-sm-9 col-xs-12">
                                <p class="col-12">{{ $water->contact }}</p>
                            </div>
                        </div>

                        <div class="row pt-3 mb-2">
                            <div class="col-sm-3 col-xs-12">
                                <p class="text-sm-right text-xs-left"><strong>Max. Tiefe</strong></p>
                            </div>
                            <div class="col-sm-9 col-xs-12">
                                <p class="col-12">{{ $water->deep }} m</p>
                            </div>
                        </div>

                        <div class="row pt-3 mb-2">
                            <div class="col-sm-3 col-xs-12">
                                <p class="text-sm-right text-xs-left"><strong>Art des Gewässers</strong></p>
                            </div>
                            <div class="col-sm-9 col-xs-12">
                                <p class="col-12">{{ $water->current->label }}</p>
                            </div>
                        </div>

                        <div id="fliessV-container" class="row pt-3 mb-2">
                            <div class="col-sm-3 col-xs-12">
                                <p class="text-sm-right text-xs-left"><strong>Max. Fließgeschindigkeit</strong></p>
                            </div>
                            <div class="col-sm-9 col-xs-12">
                                <p class="col-12">{{ $water->currentV }} m/s</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
