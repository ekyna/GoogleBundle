<?php

namespace Ekyna\Bundle\GoogleBundle\Twig;

use Ivory\GoogleMapBundle\Twig\ApiExtension as BaseExtension;

/**
 * Class ApiExtension
 * @package Ekyna\Bundle\GoogleBundle\Twig
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class ApiExtension extends BaseExtension
{
    use MapPoolAwareTrait;


    /**
     * @inheritDoc
     */
    public function render(array $objects = null)
    {
        if (null === $objects) {
            $objects = $this->mapPool->all();
        }

        if (empty($objects)) {
            return '';
        }

        $mapMaps = [];
        /** @var \Ivory\GoogleMap\Map $map */
        foreach ($objects as $map) {
            $mapMaps[] = "{element: '{$map->getHtmlId()}', map: '{$map->getVariable()}'}";
        }
        $mapMaps = 'var maps = [' . join(',', $mapMaps) . ']';

        $js = <<<EOT
<script type="text/javascript">
require(['jquery'], function($) {
    $mapMaps;
    function checkMaps() {
        var check = true;
        for (key in maps) {
            if (maps.hasOwnProperty(key)) {
                if (!window.hasOwnProperty(maps[key].map)) {
                    return false;
                }
            }
        }
        return true;
    }
    function initMapTabs() {
        $.each(maps, function(key, value) {
            var pane = $('#' + value.element).closest('.tab-pane');
            if (pane.length) {
                $('a[href="#' + pane.attr('id') + '"]').on("shown.bs.tab", function() {
                    var map = window[value.map]; 
                    center=map.getCenter();
                    google.maps.event.trigger(map, "resize");
                    map.setCenter(center);
                });
            }
        });
    }
    var i = setInterval(function() {
        if (checkMaps()) {
            clearInterval(i);
            initMapTabs();
        }      
    }, 100);
});
</script>
EOT;

        return parent::render($objects) . $js;
    }
}
