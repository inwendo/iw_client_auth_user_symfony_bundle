<?php

namespace Inwendo\Auth\LoginBundle\Tools;


use Inwendo\Auth\LoginBundle\Entity\ServiceAccount;
use Inwendo\Auth\LoginBundle\Entity\ServiceProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoginService
{
    /**
     * @var ContainerInterface $containerInterface
     */
    private $containerInterface;

    /**
     * @var \Doctrine\Bundle\DoctrineBundle\Registry
     */
    private $db;

    /**
     * LoginService constructor.
     * @param ContainerInterface $containerInterface
     */
    public function __construct(ContainerInterface $containerInterface)
    {
        $this->containerInterface = $containerInterface;
        $this->db = $this->containerInterface->get('doctrine');
    }

    /**
     * @param ServiceProvider $provider
     * @param ServiceAccount $account
     * @return bool
     */
    public function login(ServiceProvider $provider, ServiceAccount $account){
        if($provider == null || $account == null){
            $this->containerInterface->get("logger")->addWarning("LoginService:login Missing Parameter");
            return false;
        }
        $genericProvider = ServiceProviderMapper::convertToGenericProvider($provider);
        try {
            // Try to get an access token using the resource owner password credentials grant.
            $loginResult = $genericProvider->getAccessToken('password', [
                'username' => $account->getUsername(),
                'password' => $account->getPassword()
            ]);
            $account->setAccessToken($loginResult->getToken());
            $account->setRefreshToken($loginResult->getRefreshToken());

            $date = new \DateTime();
            $date->setTimestamp($loginResult->getExpires());
            $account->setTokenValidUntil($date);

            return true;

        } catch (IdentityProviderException $e) {
            // Failed to get the access token
            $this->containerInterface->get("logger")->addCritical($e->getMessage());
        }
        return false;
    }

    /**
     * @param ServiceProvider $provider
     * @param ServiceAccount $account
     * @return bool
     */
    public function refreshLogin(ServiceProvider $provider, ServiceAccount $account){
        if($provider == null || $account == null){
            $this->containerInterface->get("logger")->addWarning("LoginService:refreshLogin Missing Parameter");
            return false;
        }
        $genericProvider = ServiceProviderMapper::convertToGenericProvider($provider);
        try {
            $loginResult = $genericProvider->getAccessToken('refresh_token', [
                'refresh_token' => $account->getRefreshToken()
            ]);

            $account->setAccessToken($loginResult->getToken());

            $date = new \DateTime();
            $date->setTimestamp($loginResult->getExpires());
            $account->setTokenValidUntil($date);

            return true;

        } catch (IdentityProviderException $e) {
            // Failed to get the access token
            $this->containerInterface->get("logger")->addCritical($e->getMessage());
        }
        return false;
    }

    /**
     * @param ServiceProvider $provider
     * @param ServiceAccount $account
     * @return bool
     */
    public function checkLogin($provider, $account){
        if($provider == null || $account == null){
            $this->containerInterface->get("logger")->addWarning("LoginService:checkLogin Missing Parameter");
            return false;
        }
        if($account->hasValidToken()){
            return true;
        }elseif ($account->getRefreshToken() != null){
            $return = $this->refreshLogin($provider, $account);
            $this->db->getManager()->flush();
            if($return){
                return $return;
            }
        }
        // fallback & new login
        $return = $this->login($provider, $account);
        $this->db->getManager()->flush();
        return $return;
    }
}