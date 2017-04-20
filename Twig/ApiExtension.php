<?php

declare(strict_types=1);

namespace Ekyna\Bundle\GoogleBundle\Twig;

use Ekyna\Bundle\GoogleBundle\Map\MapPoolAwareTrait;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMapBundle\Twig\ApiExtension as BaseExtension;

/**
 * Class ApiExtension
 * @package Ekyna\Bundle\GoogleBundle\Twig
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class ApiExtension extends BaseExtension
{
    use MapPoolAwareTrait;


    public function render(array $objects = null): string
    {
        if (null === $objects) {
            $objects = $this->mapPool->all();
        }

        if (empty($objects)) {
            return '';
        }

        $mapMaps = [];
        /** @var Map $map */
        foreach ($objects as $map) {
            $mapMaps[] = "{element: '{$map->getHtmlId()}', map: '{$map->getVariable()}'}";
        }
        $mapMaps = 'var maps = [' . join(',', $mapMaps) . ']';

        $js = <<<EOT
<script type="text/javascript">
require(['jquery'], function($) {
    $mapMaps;
    function checkMaps() {
        for (var key in maps) {
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
            const pane = $('#' + value.element).closest('.tab-pane');
            if (pane.length) {
                $('a[href="#' + pane.attr('id') + '"]').on("shown.bs.tab", function() {
                    let map = window[value.map]; 
                    let center=map.getCenter();
                    google.maps.event.trigger(map, "resize");
                    map.setCenter(center);
                });
            }
        });
    }
    let i = setInterval(function() {
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
