<?php

declare(strict_types=1);

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


    public function render(Map $map, array $attributes = []): string
    {
        $this->mapPool->add($map);

        return parent::render($map, $attributes);
    }

    public function renderHtml(Map $map, array $attributes = []): string
    {
        $this->mapPool->add($map);

        return parent::renderHtml($map, $attributes);
    }
}
