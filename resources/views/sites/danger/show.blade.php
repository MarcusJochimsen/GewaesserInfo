@extends('common.base')

@section('water')
    {{ $danger->water->name }}
@endsection

@section('head')
    <script type="application/javascript">
        let googleMaps = new GoogleMaps('{{ env('GOOGLE_MAPS_API') }}');

        function initMap() {
            googleMaps.initShowWaterMeta('{{ $danger->water->center_lat }}', '{{ $danger->water->center_lng }}', '{{ $danger->marker }}');
        }
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
                <h3>{{ $danger->name }} <br><small>{{ $danger->water->name }} in {{ $danger->water->location }}</small></h3>
            </div>

            <div class="title_right">
                <div class="col-md-6 col-sm-6 col-xs-12 pull-right top_search d-flex justify-content-end flex-wrap">
                    <div class="btn-group ml-3 mb-3">
                        <a class="btn btn-info" type="button" target="_self" href="{{ route('water.show', ['water' => $danger->water->id]) }}" title="Gewässer"><i class="fas fa-water" aria-hidden="true"></i></a>
                        <a class="btn btn-info" type="button" target="_self" href="{{ route('driveway.index', ['water' => $danger->water->id]) }}" title="Zufahrten"><i class="fas fa-route" aria-hidden="true"></i></a>
                    </div>
                    <div class="btn-group ml-3 mb-3">
                        <a class="btn btn-info" type="button" target="_self" href="{{ route('danger.edit', ['water' => $danger->water->id, 'danger' => $danger->id]) }}" title="Bearbeiten"><i class="far fa-edit" aria-hidden="true"></i></a>
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
                                <p class="col-12">{{ $danger->water->description }}</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
