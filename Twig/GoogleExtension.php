<?php

namespace Ekyna\Bundle\GoogleBundle\Twig;

use Ekyna\Bundle\SettingBundle\Manager\SettingsManagerInterface;

/**
 * Class GoogleExtension
 * @package Ekyna\Bundle\GoogleBundle\Twig
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class GoogleExtension extends \Twig_Extension
{
    const GA_TRACKING_CODE = <<<EOT
<script async src="https://www.googletagmanager.com/gtag/js?id=__CODE__"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', '__CODE__');
</script>
EOT;

    /**
     * @var SettingsManagerInterface
     */
    protected $settingManager;

    /**
     * @var bool
     */
    protected $debug;


    /**
     * Constructor.
     *
     * @param SettingsManagerInterface $settingManager
     * @param bool $debug
     */
    public function __construct(SettingsManagerInterface $settingManager, $debug)
    {
        $this->settingManager = $settingManager;
        $this->debug = $debug;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('ekyna_google_tracking', [$this, 'getGoogleTracking'], ['is_safe' => ['html']])
        ];
    }

    /**
     * Renders the google analytics tracking code.
     *
     * @return string
     */
    public function getGoogleTracking()
    {
        $propertyId = $this->settingManager->getParameter('google.property_id');
        if (!$this->debug && !empty($propertyId)) {
            return str_replace('__CODE__', $propertyId, self::GA_TRACKING_CODE);
        }
        return '';
    }
}
