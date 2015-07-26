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
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    ga('create', '%s', %s);
    ga('send', 'pageview');
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
        return array(
            new \Twig_SimpleFunction('ekyna_google_tracking', array($this, 'getGoogleTracking'), array('is_safe' => array('html')))
        );
    }

    /**
     * Renders the google analytics tracking code.
     *
     * @return string
     */
    public function getGoogleTracking()
    {
        /** @var \Ekyna\Bundle\GoogleBundle\Model\TrackingCode $trackingCode */
        $trackingCode = $this->settingManager->getParameter('google.tracking_code');
        if (!$this->debug && 0 < strlen($trackingCode->getPropertyId())) {
            $domain = $trackingCode->getDomain();
            if (0 === strlen($domain)) {
                $domain = 'auto';
            }
            if (in_array($trackingCode->getDomain(), array('none', 'auto'))) {
                $domain = sprintf("'%s'", $domain);
            } else {
                $domain = sprintf("{'cookieDomain': '%s'}", $domain);
            }
            return sprintf(self::GA_TRACKING_CODE, $trackingCode->getPropertyId(), $domain);
        }
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'ekyna_google';
    }
}
