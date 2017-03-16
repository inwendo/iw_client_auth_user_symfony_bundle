<?php

namespace Inwendo\Auth\LoginBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ServiceProvider
 * @package Inwendo\Auth\LoginBundle\Entity
 * @ORM\MappedSuperclass()
 */
class ServiceProvider
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="client_id", type="text")
     */
    protected $clientId;

    /**
     * @var string
     *
     * @ORM\Column(name="client_secret", type="text")
     */
    protected $clientSecret;

    /**
     * @var string
     *
     * @ORM\Column(name="domain_uri", type="text")
     */
    protected $domainUri;

    /**
     * @var string
     *
     * @ORM\Column(name="url_redirect", type="text")
     */
    protected $urlRedirect;

    /**
     * @var string
     *
     * @ORM\Column(name="path_authorize", type="text")
     */
    protected $pathAuthorize;

    /**
     * @var string
     *
     * @ORM\Column(name="path_access_token", type="text")
     */
    protected $pathAccessToken;

    /**
     * @var string
     *
     * @ORM\Column(name="url_resource_owner_details", type="text")
     */
    protected $urlResourceOwnerDetails;

    /**
     * ServiceProvider constructor.
     * @param string $clientId
     * @param string $clientSecret
     * @param string $domainUri
     * @param string $urlRedirect
     * @param string $pathAuthorize
     * @param string $pathAccessToken
     * @param string $urlResourceOwnerDetails
     */
    public function __construct($clientId, $clientSecret, $domainUri, $urlRedirect="https://example.inwendo.de", $urlResourceOwnerDetails="https://example.inwendo.de", $pathAuthorize="/oauth/v2/auth", $pathAccessToken="/oauth/v2/token")
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->domainUri = $domainUri;
        $this->urlRedirect = $urlRedirect;
        $this->pathAuthorize = $pathAuthorize;
        $this->pathAccessToken = $pathAccessToken;
        $this->urlResourceOwnerDetails = $urlResourceOwnerDetails;
    }


    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * @param string $clientId
     */
    public function setClientId(string $clientId)
    {
        $this->clientId = $clientId;
    }

    /**
     * @return string
     */
    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    /**
     * @param string $clientSecret
     */
    public function setClientSecret(string $clientSecret)
    {
        $this->clientSecret = $clientSecret;
    }

    /**
     * @return string
     */
    public function getDomainUri(): string
    {
        return $this->domainUri;
    }

    /**
     * @param string $domainUri
     */
    public function setDomainUri(string $domainUri)
    {
        $this->domainUri = $domainUri;
    }

    /**
     * @return string
     */
    public function getUrlRedirect(): string
    {
        return $this->urlRedirect;
    }

    /**
     * @param string $urlRedirect
     */
    public function setUrlRedirect(string $urlRedirect)
    {
        $this->urlRedirect = $urlRedirect;
    }

    /**
     * @return string
     */
    public function getPathAuthorize(): string
    {
        return $this->pathAuthorize;
    }

    /**
     * @param string $pathAuthorize
     */
    public function setPathAuthorize(string $pathAuthorize)
    {
        $this->pathAuthorize = $pathAuthorize;
    }

    /**
     * @return string
     */
    public function getPathAccessToken(): string
    {
        return $this->pathAccessToken;
    }

    /**
     * @param string $pathAccessToken
     */
    public function setPathAccessToken(string $pathAccessToken)
    {
        $this->pathAccessToken = $pathAccessToken;
    }

    /**
     * @return string
     */
    public function getUrlResourceOwnerDetails(): string
    {
        return $this->urlResourceOwnerDetails;
    }

    /**
     * @param string $urlResourceOwnerDetails
     */
    public function setUrlResourceOwnerDetails(string $urlResourceOwnerDetails)
    {
        $this->urlResourceOwnerDetails = $urlResourceOwnerDetails;
    }
}