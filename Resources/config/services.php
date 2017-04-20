<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Ekyna\Bundle\GoogleBundle\EventListener\ModalEventSubscriber;
use Ekyna\Bundle\GoogleBundle\Form\Type\CoordinateType;
use Ekyna\Bundle\GoogleBundle\GoogleClient;
use Ekyna\Bundle\GoogleBundle\Map\MapPool;
use Ekyna\Bundle\GoogleBundle\Settings\Schema;
use Ekyna\Bundle\GoogleBundle\Show\Type\GoogleCodesType;
use Ekyna\Bundle\GoogleBundle\Show\Type\GoogleMapType;
use Ekyna\Bundle\GoogleBundle\Tracking\TrackingPool;
use Ekyna\Bundle\GoogleBundle\Tracking\TrackingRenderer;
use Ekyna\Bundle\GoogleBundle\Twig\TrackingExtension;
use Ekyna\Bundle\SettingBundle\DependencyInjection\Compiler\RegisterSchemasPass;

return static function (ContainerConfigurator $container) {
    $container
        ->services()

        // Google client
        ->set('ekyna_google.client', GoogleClient::class)
            ->args([
                abstract_arg('Configuration'),
            ])

        // Form types
        ->set('ekyna_google.form_type.coordinate', CoordinateType::class)
            ->tag('form.type')
            ->tag('form.js', ['selector' => '.ekyna-google-coordinate', 'path' => 'ekyna-form/google-coordinate'])

        // Show types
        ->set('ekyna_google.show.type.google_codes', GoogleCodesType::class)
            ->tag('ekyna_admin.show.type')
        ->set('ekyna_google.show.type.google_map', GoogleMapType::class)
            ->tag('ekyna_admin.show.type')

        // Setting schema
        ->set('ekyna_google.settings.schema', Schema::class)
            ->tag(RegisterSchemasPass::TAG, ['namespace' => 'google', 'position' => 90])

        // Map pool
        ->set('ekyna_google.map.pool', MapPool::class)

        // Tracking pool
        ->set('ekyna_google.tracking.pool', TrackingPool::class)

        // Tracking renderer
        ->set('ekyna_google.tracking.renderer', TrackingRenderer::class)
            ->args([
                service('twig'),
                service('request_stack'),
                service('ekyna_setting.manager'),
                service('ekyna_google.tracking.pool'),
                abstract_arg('Configuration'),
                param('kernel.debug'),
            ])
            ->tag('twig.runtime')

        // Modal event listener
        ->set('ekyna_google.listener.modal', ModalEventSubscriber::class)
            ->args([
                service('ekyna_google.tracking.renderer')
            ])
            ->tag('kernel.event_subscriber')

        // Twig extensions
        ->set('ekyna_google.twig.tracking_extension', TrackingExtension::class)
            ->tag('twig.extension')
    ;
};
