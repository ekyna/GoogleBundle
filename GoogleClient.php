<?php

namespace Ekyna\Bundle\GoogleBundle;

/**
 * Class GoogleClient
 * @package Ekyna\Bundle\GoogleBundle
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class GoogleClient extends \Google_Client
{
    /**
     * Constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
//        $gc = new \Google_Config();
//        $gc->setApplicationName($config['application_name']);
//        $gc->setClientId($config['client_id']);
//        $gc->setClientSecret($config['client_secret']);
//        $gc->setRedirectUri($config['redirect_uri']);
//        $gc->setDeveloperKey($config['developer_key']);
//        parent::__construct($gc);

//        $gc = new \Google_Config();
//        $gc->setApplicationName('delta-compass-88413');
//        $gc->setClientId('325619265545-s52p0vqjttcmcbp4p5s70q2mbi2si9dt.apps.googleusercontent.com');
//        $gc->setClientSecret('F6P1m7Hj4q821Gu_hfQzjV-n');
//        $gc->setRedirectUri($config['redirect_uri']);
//        $gc->setDeveloperKey($config['developer_key']);
//        parent::__construct($gc);

        parent::__construct();
    }
}
