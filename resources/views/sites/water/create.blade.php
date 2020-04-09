@extends('common.base')

@section('head')
    <script type="application/javascript">
        let googleMaps = new GoogleMaps('{{ env('GOOGLE_MAPS_API') }}');

        function initMap() {
            googleMaps.initCreateWater();
        }

        $(document).ready(function () {
            $('input[type=radio][name=current_id]').change(function () {
                let value = $(this).val();
                let fliessvcontainer = $('#fliessV-container');
                let fliessv = $('#fliessV');
                if (value === '1') {
                    fliessvcontainer.addClass('d-none');
                    fliessv.val('0');
                } else {
                    fliessvcontainer.removeClass('d-none');
                }
            })
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
                <h3>Neues Gewässer erstellen</h3>
            </div>

            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    {{--                    --}}
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">

                        {{ Form::model('', ['route' => 'water.store', 'class' => 'form-horizontal form-label-left']) }}

                        <div class="form-group">
                            {{ Form::label('name', 'Name des Sees oder Flusses', ['class' => 'control-label col-sm-3 col-xs-12']) }}
                            <div class="col-sm-9 col-xs-12">
                                {{ Form::text('name', '', ['class' => 'form-control col-12']) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('', 'Position und Rahmen des Gewässers ', ['class' => 'control-label col-sm-3 col-xs-12']) }}
                            <div class="col-sm-9 col-xs-12">
                                <div id="map" class="form-map"></div>
                                {{ Form::hidden('center_lat', '', ['id' => 'center_lat']) }}
                                {{ Form::hidden('center_lng', '', ['id' => 'center_lng']) }}
                                {{ Form::hidden('bounds', '', ['id' => 'bounds']) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('location', 'Gemeinde - Ortsteil', ['class' => 'control-label col-sm-3 col-xs-12']) }}
                            <div class="col-sm-9 col-xs-12">
                                {{ Form::text('location', '', ['class' => 'form-control col-12']) }}
                            </div>
                        </div>

                        {{--                        <div class="form-group">--}}
                        {{--                            {{ Form::label('location_shown', 'Gemeinde - Ortsteil', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) }}--}}
                        {{--                            <div class="col-md-9 col-sm-9 col-xs-12">--}}
                        {{--                                {{ Form::text('location_shown', '', ['class' => 'form-control col-md-7 col-xs-12']) }}--}}
                        {{--                                {{ Form::hidden('location', '', ['id' => 'location']) }}--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}

                        <div class="form-group">
                            {{ Form::label('description', 'Beschreibung', ['class' => 'control-label col-sm-3 col-xs-12']) }}
                            <div class="col-sm-9 col-xs-12">
                                {{ Form::textarea('description', '', ['class' => 'form-control col-12']) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('dangertext', 'Gefahren', ['class' => 'control-label col-sm-3 col-xs-12']) }}
                            <div class="col-sm-9 col-xs-12">
                                {{ Form::textarea('dangertext', '', ['class' => 'form-control col-12']) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('contact', 'Ansprechpartner', ['class' => 'control-label col-sm-3 col-xs-12']) }}
                            <div class="col-sm-9 col-xs-12">
                                {{ Form::textarea('contact', '', ['class' => 'form-control col-12']) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('deep', 'Max. Tiefe (m)', ['class' => 'control-label col-sm-3 col-xs-12']) }}
                            <div class="col-sm-9 col-xs-12">
                                {{ Form::number('deep', '', ['class' => 'form-control col-12', 'min' => '0', 'step' => '1']) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('current_id', 'Art des Gewässers', ['class' => 'control-label col-sm-3 col-xs-12']) }}
                            <div class="col-sm-9 col-xs-12">
                                <div id="gender" class="btn-group" data-toggle="buttons">
                                    {{ Form::label('', Form::radio('current_id', '1', true).'stehend', ['class' => 'btn btn-default active'], false) }}
                                    {{ Form::label('', Form::radio('current_id', '2', false).'fließend', ['class' => 'btn btn-default'], false) }}
                                </div>
                            </div>
                        </div>

                        <div id="fliessV-container" class="form-group d-none">
                            {{ Form::label('currentV', 'Max. Fließgeschindigkeit (m/s)', ['class' => 'control-label col-sm-3 col-xs-12']) }}
                            <div class="col-sm-9 col-xs-12">
                                {{ Form::number('currentV', '0', ['class' => 'form-control col-12', 'min' => '0', 'step' => '1']) }}
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
