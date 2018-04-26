define('ekyna-form/google-coordinate', ['jquery'], function ($) {
    "use strict";

    var CoordinateWidget = function ($elem) {
        this.$elem = $($elem);
        this.defaults = {types: [], controls: []};
        this.config = $.extend({}, this.defaults, this.$elem.data('config'));
    };

    CoordinateWidget.prototype = {
        constructor: CoordinateWidget,
        init: function () {
            this.googleInitCount = 0;
            this.geocodeTimeout = null;

            // Address fields
            var $form = this.$elem.closest('.address');
            this.$street = $form.find('.address-street');
            this.$postalCode = $form.find('.address-postal-code');
            this.$city = $form.find('.address-city');
            this.$country = $form.find('.address-country');
            this.$state = $form.find('.address-state');

            // Coordinate fields
            var id = this.$elem.attr('id');
            this.$latInput = this.$elem.find('#' + id + '_latitude');
            this.$lngInput = this.$elem.find('#' + id + '_longitude');

            // Map and marker
            this.map = window[this.config['map_var']];
            this.marker = window[this.config['marker_var']];

            this.initGoogle();

        },
        initGoogle: function () {
            var that = this;
            if (!window.hasOwnProperty('google') || !google.hasOwnProperty('maps')) {
                this.googleInitCount++;
                if (10 > this.googleInitCount) {
                    setTimeout(function () {
                        that.initGoogle()
                    }, 200);
                }

                return;
            }

            this.geocoder = new google.maps.Geocoder();

            this.initFieldHandler(this.$street);
            this.initFieldHandler(this.$postalCode);
            this.initFieldHandler(this.$city);
            this.initFieldHandler(this.$country);
            this.initFieldHandler(this.$state);

            this.geocodeAddress();

            // Bootstrap tabs
            var $bsTabPane = this.$elem.closest('.tab-pane');
            if ($bsTabPane.length) {
                $('a[href="#' + $bsTabPane.attr('id') + '"]').on("shown.bs.tab", function () {
                    that.redraw();
                });
            }

            // Window resize
            $(window).on('resize', function () {
                that.redraw();
            });
        },
        redraw: function () {
            var center = this.map.getCenter();
            google.maps.event.trigger(this.map, "resize");
            this.map.setCenter(center);
        },
        initFieldHandler: function ($field) {
            var that = this;
            $field.on('change', function () {
                if (null !== that.geocodeTimeout) {
                    clearTimeout(that.geocodeTimeout);
                }
                that.geocodeTimeout = setTimeout(function () {
                    that.geocodeAddress();
                }, 3000);
            });
        },
        geocodeAddress: function () {
            var that = this,
                address = this.buildAddress();

            if (0 === address.length) {
                that.$latInput.val(null);
                that.$lngInput.val(null);

                return;
            }

            this.geocoder.geocode({'address': address}, function (results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    var location = results[0].geometry.location;

                    google.maps.event.trigger(that.map, "resize");
                    that.map.setCenter(location);
                    that.marker.setPosition(location);

                    that.$latInput.val(location.lat());
                    that.$lngInput.val(location.lng());

                    that.geocodeTimeout = null;
                } else {
                    console.log('Geocode was not successful for the following reason: ' + status);
                }
            });
        },
        buildAddress: function () {
            var parts = [];

            if (this.$street.val()) parts.push(this.$street.val());
            if (this.$postalCode.val()) parts.push(this.$postalCode.val());
            if (this.$city.val()) parts.push(this.$city.val());
            if (this.$country.val()) parts.push(this.$country.val());
            if (this.$state && this.$state.val()) parts.push(this.$state.val());

            return parts.join(' ');
        }
    };

    return {
        init: function ($element) {
            $element.each(function () {
                new CoordinateWidget($(this)).init();
            });
        }
    };
});
