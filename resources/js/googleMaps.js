class GoogleMaps {
    constructor(apiKey, elementId) {
        this.apiKey = apiKey;
        this.elementId = elementId;
        this.markers = [];

        if (this.elementId === undefined) {
            this.elementId = 'map';
        }
    }

    async initMap(base, zoom, disableDefaultUI) {
        if (base === undefined) {
            let geoLocation = await this.getGeoLocation();
            base = new google.maps.LatLng(geoLocation.coords.latitude, geoLocation.coords.longitude);
        } else if (typeof base !== "object") {
            base = this.getJSON(base);
        }

        if (zoom === undefined) {
            zoom = 11;
        }

        if (disableDefaultUI === undefined) {
            disableDefaultUI = false;
        }

        this.map = new google.maps.Map(document.getElementById(this.elementId), {
            center: base,
            zoom: zoom,
            streetViewControl: false,
            disableDefaultUI: disableDefaultUI
        });
    }

    getGeoLocation() {
        // Simple wrapper
        return new Promise((res, rej) => {
            navigator.geolocation.getCurrentPosition(res, rej);
        });
    }

    getJSON(location) {
        let base = location;
        base = base.replace(/&quot;/g, '\"');
        base = base.replace(/null/g, '\"null\"');
        return jQuery.parseJSON(base);
        // return JSON.parse(base);
    }

    setMarker(latLng) {
        if (this.markers.length < 1) {
            let marker = new google.maps.Marker({
                position: latLng,
                map: this.map,
                draggable: true,
                title: 'Verschieben'
            });
            this.markers.push(marker);

            $("#center_lat").val(marker.getPosition().lat());
            $("#center_lng").val(marker.getPosition().lng());

            marker.addListener('dragend', function () {
                $("#center_lat").val(marker.getPosition().lat());
                $("#center_lng").val(marker.getPosition().lng());
            });
        }
    }

    setMetaMarker(latLng) {
        if (this.markers.length < 1) {
            let marker = new google.maps.Marker({
                position: latLng,
                map: this.map,
                draggable: true,
                title: 'Verschieben'
            });
            this.markers.push(marker);

            $("#marker").val(JSON.stringify(marker.getPosition().toJSON()));

            marker.addListener('dragend', function () {
                $("#marker").val(JSON.stringify(marker.getPosition().toJSON()));
            });
        }
    }

    setBounds(bounds) {
        // Define a rectangle and set its editable property to true.
        let rectangle = new google.maps.Rectangle({
            bounds: bounds,
            editable: true
        });
        rectangle.setMap(this.map);

        $("#bounds").val(JSON.stringify(rectangle.getBounds().toJSON()));

        rectangle.addListener('bounds_changed', function () {
            $("#bounds").val(JSON.stringify(rectangle.getBounds().toJSON()));
        });
    }

    setIndexMetaMarker(markers_url, meta_route, bounds, metatype) {
        this.map.fitBounds(this.getJSON(bounds));

        let label_icon = '\uf111';
        if (metatype === 'danger') {
            label_icon = '\uf071';
        } else if (metatype === 'driveway') {
            label_icon = '\uf4d7';
        }

        let round = 0;
        let _this = this;
        this.map.addListener('idle', function () {
            if (round < 1) {
                let bounds = _this.map.getBounds();
                let infoWindow = new google.maps.InfoWindow;

                $.ajax({
                    method: "GET",
                    url: markers_url,
                    dataType: "json",
                    success: function (markers) {
                        Array.prototype.forEach.call(markers, function (markerData) {
                            let marker = new google.maps.Marker({
                                map: _this.map,
                                position: _this.getJSON(markerData.marker),
                                label: {
                                    fontFamily: "'Font Awesome 5 Free'",
                                    text: label_icon,
                                    fontWeight: '900',
                                    fontSize: '16px',
                                    color: '#610f0d',
                                },
                            });
                            bounds.extend(marker.getPosition());

                            let infowincontent = document.createElement('div');
                            let strong = document.createElement('strong');
                            let link = document.createElement('a');
                            link.target = "_self";
                            link.href = meta_route.replace('replaceMe', markerData.id);
                            link.textContent = markerData.name;
                            strong.appendChild(link);
                            infowincontent.appendChild(strong);

                            marker.addListener('click', function () {
                                infoWindow.setContent(infowincontent);
                                infoWindow.open(_this.map, marker);
                            });
                        });
                        _this.map.fitBounds(bounds);
                        _this.map.setZoom(_this.map.getZoom()+1);
                    },
                });
                round++;
            }
        });
    }


    async initCreateWater() {
        let center_lat = $("#center_lat").val();
        let center_lng = $("#center_lng").val();

        if (center_lat === undefined || center_lng === undefined || center_lat === "" || center_lng === "") {
            await this.initMap(undefined, undefined);
        } else {
            await this.initMap(new google.maps.LatLng(center_lat, center_lng), 15);
            this.setMarker(base);
        }

        let bounds = $("#bounds").val();
        if (bounds !== '') {
            this.setBounds(this.getJSON(bounds));
        }

        let _this = this;
        this.map.addListener('click', function (e) {
            const bounds = {
                north: e.latLng.lat() + 0.001,
                south: e.latLng.lat() - 0.001,
                east: e.latLng.lng() + 0.002,
                west: e.latLng.lng() - 0.002
            };
            _this.setMarker(e.latLng);
            // googleMaps.getLocation(googlemap.marker.getPosition());
            _this.setBounds(bounds);

            _this.map.panTo(e.latLng);
            _this.map.setZoom(15);
        });
    }

    async initIndexWater(markers_url, water_route) {
        await this.initMap(undefined, undefined);

        let _this = this;
        this.map.addListener('idle', function () {
            let bounds = _this.map.getBounds();
            let ne = bounds.getNorthEast();
            let sw = bounds.getSouthWest();

            let infoWindow = new google.maps.InfoWindow;

            $.ajax({
                method: "GET",
                url: markers_url + "?north=" + ne.lat() + "&south=" + sw.lat() + "&west=" + sw.lng() + "&east=" + ne.lng(),
                dataType: "json",
            }).success(function (markers) {
                Array.prototype.forEach.call(markers, function (markerData) {
                    let point = new google.maps.LatLng(
                        parseFloat(markerData.center_lat),
                        parseFloat(markerData.center_lng)
                    );
                    let marker = new google.maps.Marker({
                        map: _this.map,
                        position: point
                    });

                    let infowincontent = document.createElement('div');
                    let strong = document.createElement('strong');
                    let link = document.createElement('a');
                    link.target = "_self";
                    link.href = water_route.replace('replaceMe', markerData.id);
                    link.textContent = markerData.name;
                    strong.appendChild(link);
                    infowincontent.appendChild(strong);

                    marker.addListener('click', function () {
                        infoWindow.setContent(infowincontent);
                        infoWindow.open(_this.map, marker);
                    });
                });
            });
        });
    }

    async initShowWater(center_lat, center_lng, bounds) {
        let center = new google.maps.LatLng(center_lat, center_lng);
        await this.initMap(center, undefined);

        this.map.fitBounds(this.getJSON(bounds));

        let marker = new google.maps.Marker({
            map: this.map,
            position: center
        });
    }

    async initEditWater(center_lat, center_lng, bounds) {
        let center = new google.maps.LatLng(center_lat, center_lng);
        await this.initMap(center, undefined);

        this.map.fitBounds(this.getJSON(bounds));

        this.setMarker(center);
        this.setBounds(this.getJSON(bounds));
    }

    async initCreateWaterMeta(center_lat, center_lng, bounds) {
        let center = new google.maps.LatLng(center_lat, center_lng);
        await this.initMap(center, undefined);

        this.map.fitBounds(this.getJSON(bounds));

        // let basemarker = new google.maps.Marker({
        //     map: this.map,
        //     position: center
        // });

        let marker = $("#marker").val();

        if (marker !== undefined && marker !== "") {
            this.setMetaMarker(this.getJSON(marker));
        }

        let _this = this;
        this.map.addListener('click', function (e) {
            _this.setMetaMarker(e.latLng);
        });
    }

    async initIndexWaterMeta(markers_url, meta_route, bounds, metatype) {
        await this.initMap(undefined, undefined);
        this.setIndexMetaMarker(markers_url, meta_route, bounds, metatype);
    }

    async initShowWaterMeta(center_lat, center_lng, meta_marker_pos) {
        let center = new google.maps.LatLng(center_lat, center_lng);
        await this.initMap(center, undefined);

        let bounds = new google.maps.LatLngBounds();
        bounds.extend(this.getJSON(meta_marker_pos));
        bounds.extend(center);
        this.map.fitBounds(bounds);

        // let marker = new google.maps.Marker({
        //     map: this.map,
        //     position: center
        // });

        let meta_marker = new google.maps.Marker({
            map: this.map,
            position: this.getJSON(meta_marker_pos)
        });
    }

    async initEditWaterMeta(marker) {
        await this.initMap(this.getJSON(marker), undefined);
        this.setMetaMarker(this.getJSON(marker));
        this.map.setZoom(17);
    }

    initPrintWater(waterObj, drivewaysObj, dangersObj) {
        /*  */
    }
}

export default GoogleMaps;
