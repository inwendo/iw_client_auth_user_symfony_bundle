<?php

namespace Inwendo\Auth\LoginBundle\Tools;


use Inwendo\Auth\LoginBundle\Entity\ServiceProvider;
use League\OAuth2\Client\Provider\GenericProvider;

class ServiceProviderMapper
{
    /**
     * @param ServiceProvider $provider
     * @return GenericProvider
     */
    static function convertToGenericProvider(ServiceProvider $provider){
        return new GenericProvider([
            'clientId'                => $provider->getClientId(),    // The client ID assigned to you by the provider
            'clientSecret'            => $provider->getClientSecret(),   // The client password assigned to you by the provider
            'redirectUri'             => $provider->getUrlRedirect(),
            'urlAuthorize'            => $provider->getDomainUri().$provider->getPathAuthorize(),
            'urlAccessToken'          => $provider->getDomainUri().$provider->getPathAccessToken(),
            'urlResourceOwnerDetails' => $provider->getUrlResourceOwnerDetails()
        ]);
    }
}