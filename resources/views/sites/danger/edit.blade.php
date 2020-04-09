@extends('common.base')

@section('water')
    {{ $danger->water->name }}
@endsection

@section('head')
    <script type="application/javascript">
        let googleMaps = new GoogleMaps('{{ env('GOOGLE_MAPS_API') }}');

        function initMap() {
            googleMaps.initEditWaterMeta('{{ $danger->marker }}');
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
                <h3>{{ $danger->name }} bearbeiten <br><small>{{ $danger->water->name }} in {{ $danger->water->location }}</small></h3>
            </div>

            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <!-- -->
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">

                        {{ Form::model('', ['route' => ['danger.update', 'water' => $danger->water->id, 'danger' => $danger->id], 'method' => 'PATCH', 'class' => 'form-horizontal form-label-left']) }}

                        <div class="form-group">
                            {{ Form::label('', 'Position der Gefahrenstelle', ['class' => 'control-label col-sm-3 col-xs-12']) }}
                            <div class="col-sm-9 col-xs-12">
                                <div id="map" class="form-map"></div>
                                {{ Form::hidden('marker', $danger->marker, ['id' => 'marker']) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('name', 'Bezeichnung', ['class' => 'control-label col-sm-3 col-xs-12']) }}
                            <div class="col-sm-9 col-xs-12">
                                {{ Form::text('name', $danger->name, ['class' => 'form-control col-12']) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('description', 'Beschreibung', ['class' => 'control-label col-sm-3 col-xs-12']) }}
                            <div class="col-sm-9 col-xs-12">
                                {{ Form::textarea('description', $danger->description, ['class' => 'form-control col-12']) }}
                            </div>
                        </div>

                        <div class="ln_solid"></div>

                        <div class="form-group">
                            <div class="col-sm-9 col-xs-12 col-sm-offset-3">
                                {{ Form::submit('Speichern', ['class' => 'btn btn-success']) }}
                            </div>
                        </div>

                        {{ Form::close() }}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
