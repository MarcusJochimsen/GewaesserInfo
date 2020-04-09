@extends('common.base')

@section('water')
    {{ $water->name }}
@endsection

@section('head')
    <script type="application/javascript">
        let googleMaps = new GoogleMaps('{{ env('GOOGLE_MAPS_API') }}');

        function initMap() {
            googleMaps.initIndexWaterMeta('{{ route('danger.markers', ['water' => $water->id]) }}', '{{ route('danger.show', ['water' => $water->id, 'danger' => 'replaceMe']) }}', '{{ $water->bounds }}', 'danger');
        }

        $(document).ready(function () {
            $('body').addClass('footer_fixed');
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
                <h3>Gefahrenstellen <br><small>{{ $water->name }} in {{ $water->location }}</small></h3>
            </div>

            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search d-flex justify-content-end flex-wrap">
                    <div class="btn-group ml-3 mb-3">
                        <a class="btn btn-info" type="button" target="_self" href="{{ route('water.show', ['water' => $water->id]) }}" title="Gewässer"><i class="fas fa-water" aria-hidden="true"></i></a>
                        <a class="btn btn-info" type="button" target="_self" href="{{ route('driveway.index', ['water' => $water->id]) }}" title="Zufahrten"><i class="fas fa-route" aria-hidden="true"></i></a>
                    </div>
                    <div class="btn-group ml-3 mb-3">
                        <a class="btn btn-info" type="button" target="_self" href="{{ route('danger.create', ['water' => $water->id]) }}" title="Erstellen"><i class="far fa-plus-square"></i></a>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
