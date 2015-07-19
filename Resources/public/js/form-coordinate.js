define('ekyna-form/google-coordinate', ['jquery'], function($) {
    "use strict";

    var CoordinateWidget = function($elem) {
        this.$elem = $($elem);
        this.defaults = {types: [], controls: []};
        this.config = $.extend({}, this.defaults, this.$elem.data('config'));
    };

    CoordinateWidget.prototype = {
        constructor: CoordinateWidget,
        init: function () {
            var that = this;
            that.geocodeTimeout = null;

            // Address fields
            var $form = this.$elem.parents('form').eq(0);
            that.$street = $form.find('[data-role="street"]');
            that.initFieldHandler(that.$street);
            that.$postalCode = $form.find('[data-role="postal-code"]');
            that.initFieldHandler(that.$postalCode);
            that.$city = $form.find('[data-role="city"]');
            that.initFieldHandler(that.$city);
            that.$country = $form.find('[data-role="country"]');
            that.initFieldHandler(that.$country);
            that.$state = $form.find('[data-role="state"]');
            that.initFieldHandler(that.$state);

            // Coordinate fields
            var id = that.$elem.attr('id');
            that.$latInput = that.$elem.find('#' + id + '_latitude');
            that.$lngInput = that.$elem.find('#' + id + '_longitude');

            // Map and marker
            that.map = window[that.config['map_var']];
            that.marker = window[that.config['marker_var']];

            // Geocoder
            that.geocoder = new google.maps.Geocoder();

            that.geocodeAddress();
        },
        initFieldHandler: function ($field) {
            var that = this;
            $field.on('change', function() {
                if (null !== that.geocodeTimeout) {
                    clearTimeout(that.geocodeTimeout);
                }
                that.geocodeTimeout = setTimeout(function() { that.geocodeAddress(); }, 3000);
            });
        },
        geocodeAddress: function() {
            var that = this;
            that.geocoder.geocode({'address': that.buildAddress()}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    var location = results[0].geometry.location;

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
        buildAddress: function() {
            var that = this, parts = [];

            if (that.$street.val().length) parts.push(that.$street.val());
            if (that.$postalCode.val().length) parts.push(that.$postalCode.val());
            if (that.$city.val().length) parts.push(that.$city.val());
            if (that.$country.val().length) parts.push(that.$country.val());
            if (that.$state.val().length) parts.push(that.$state.val());

            return parts.join(', ');
        }
    };

    return {
        init: function($element) {
            $element.each(function() {
                new CoordinateWidget($(this)).init();
            });
        }
    };
});
