<?php

namespace Ekyna\Bundle\GoogleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class TestController
 * @package Ekyna\Bundle\GoogleBundle\Controller
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class TestController extends Controller
{
    public function testAction()
    {
        $client = $this->get('ekyna_google.client');
        $client->setUseObjects(true);

        //$client->setAuthConfig('{"web":{"auth_uri":"https://accounts.google.com/o/oauth2/auth","client_secret":"F6P1m7Hj4q821Gu_hfQzjV-n","token_uri":"https://accounts.google.com/o/oauth2/token","client_email":"325619265545-s52p0vqjttcmcbp4p5s70q2mbi2si9dt@developer.gserviceaccount.com","client_x509_cert_url":"https://www.googleapis.com/robot/v1/metadata/x509/325619265545-s52p0vqjttcmcbp4p5s70q2mbi2si9dt@developer.gserviceaccount.com","client_id":"325619265545-s52p0vqjttcmcbp4p5s70q2mbi2si9dt.apps.googleusercontent.com","auth_provider_x509_cert_url":"https://www.googleapis.com/oauth2/v1/certs"}}');

//        $token = $client->getAccessToken();
//        var_dump($token);
//        exit();

        $client->setApplicationName("Test project");
        //$client->setDeveloperKey("AIzaSyBQXhYai0pkg-ZhaBmP36372n1GZSw4qfo");
//        $client->setClientId('325619265545-s52p0vqjttcmcbp4p5s70q2mbi2si9dt.apps.googleusercontent.com');
//        $client->setClientSecret('F6P1m7Hj4q821Gu_hfQzjV-n');

        $client->setAuthConfig('{"web":{"auth_uri":"https://accounts.google.com/o/oauth2/auth","client_secret":"F6P1m7Hj4q821Gu_hfQzjV-n","token_uri":"https://accounts.google.com/o/oauth2/token","client_email":"325619265545-s52p0vqjttcmcbp4p5s70q2mbi2si9dt@developer.gserviceaccount.com","client_x509_cert_url":"https://www.googleapis.com/robot/v1/metadata/x509/325619265545-s52p0vqjttcmcbp4p5s70q2mbi2si9dt@developer.gserviceaccount.com","client_id":"325619265545-s52p0vqjttcmcbp4p5s70q2mbi2si9dt.apps.googleusercontent.com","auth_provider_x509_cert_url":"https://www.googleapis.com/oauth2/v1/certs"}}');


        $analytics = new \Google_Service_Analytics($client);
        $ret = $analytics->data_ga->get('UA-10227193-10', '2015-03-01', '2015-03-14', 'ga:pageviews');
        var_dump($ret->count());




        exit();



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
        $optParams = array('filter' => 'free-ebooks');
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
        $optParams = array('filter' => 'free-ebooks');
        $request = $service->volumes->listVolumes('Henry David Thoreau', $optParams);
        $results = $client->execute($request);

        echo "<h3>Results Of Deferred Call:</h3>";
        foreach ($results as $item) {
            echo $item['volumeInfo']['title'], "<br /> \n";
        }

        exit();
    }
}
