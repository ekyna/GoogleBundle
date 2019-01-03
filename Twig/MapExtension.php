<?php

namespace Ekyna\Bundle\GoogleBundle\Twig;

use Ekyna\Bundle\GoogleBundle\Map\MapPoolAwareTrait;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMapBundle\Twig\MapExtension as BaseExtension;

/**
 * Class MapExtension
 * @package Ekyna\Bundle\GoogleBundle\Twig
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class MapExtension extends BaseExtension
{
    use MapPoolAwareTrait;


    /**
     * @inheritDoc
     */
    public function render(Map $map, array $attributes = [])
    {
        $this->mapPool->add($map);

        return parent::render($map, $attributes);
    }

    /**
     * @inheritDoc
     */
    public function renderHtml(Map $map, array $attributes = [])
    {
        $this->mapPool->add($map);

        return parent::renderHtml($map, $attributes);
    }
}
