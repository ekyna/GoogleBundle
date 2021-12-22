<?php

declare(strict_types=1);

namespace Ekyna\Bundle\GoogleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class TestController
 * @package Ekyna\Bundle\GoogleBundle\Controller
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class TestController extends AbstractController
{
    public function testAction()
    {
        $client = $this->get('ekyna_google.client');

        $service = new \Google_Service_Books($client);

        /************************************************
        We make a call to our service, which will
        normally map to the structure of the API.
        In this case $service is Books API, the
        resource is volumes, and the method is
        listVolumes. We pass it a required parameters
        (the query), and an array of named optional
        parameters.
         ************************************************/
        $optParams = ['filter' => 'free-ebooks'];
        $results = $service->volumes->listVolumes('Henry David Thoreau', $optParams);

        /************************************************
        This call returns a list of volumes, so we
        can iterate over them as normal with any
        array.
        Some calls will return a single item which we
        can immediately use. The individual responses
        are typed as Google_Service_Books_Volume, but
        can be treated as an array.
         ***********************************************/
        echo "<h3>Results Of Call:</h3>";
        foreach ($results as $item) {
            echo $item['volumeInfo']['title'], "<br /> \n";
        }

        /************************************************
        This is an example of deferring a call.
         ***********************************************/
        $client->setDefer(true);
        $optParams = ['filter' => 'free-ebooks'];
        $request = $service->volumes->listVolumes('Henry David Thoreau', $optParams);
        $results = $client->execute($request);

        echo "<h3>Results Of Deferred Call:</h3>";
        foreach ($results as $item) {
            echo $item['volumeInfo']['title'], "<br /> \n";
        }

        exit();
    }
}
