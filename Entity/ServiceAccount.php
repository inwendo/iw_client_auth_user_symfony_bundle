<?php

namespace Inwendo\Auth\LoginBundle\Entity;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ServiceAccount
 * @package Inwendo\Auth\LoginBundle\Entity
 * @ORM\MappedSuperclass()
 */
abstract class ServiceAccount
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
     * @var integer
     *
     * @ORM\Column(name="local_user_id", type="integer", unique=true)
     */
    protected $localUserId;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255)
     */
    protected $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    protected $password;

    /**
     * @var string
     *
     * @ORM\Column(name="access_token", type="text", nullable=true)
     */
    protected $accessToken;

    /**
     * @var string
     *
     * @ORM\Column(name="refresh_token", type="text", nullable=true)
     */
    protected $refreshToken;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="token_valid_until", type="datetime", nullable=true)
     */
    protected $tokenValidUntil;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getLocalUserId()
    {
        return $this->localUserId;
    }

    /**
     * @param int $localUserId
     */
    public function setLocalUserId($localUserId)
    {
        $this->localUserId = $localUserId;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return string
     */
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    /**
     * @param string $refreshToken
     */
    public function setRefreshToken($refreshToken)
    {
        $this->refreshToken = $refreshToken;
    }

    /**
     * @return \DateTime
     */
    public function getTokenValidUntil()
    {
        return $this->tokenValidUntil;
    }

    /**
     * @param \DateTime $tokenValidUntil
     */
    public function setTokenValidUntil($tokenValidUntil)
    {
        $this->tokenValidUntil = $tokenValidUntil;
    }

    /**
     * @return bool
     */
    public function hasValidToken(){
        if($this->getTokenValidUntil() != null){
            if($this->getTokenValidUntil() > new \DateTime()){
                return true;
            }
        }
        return false;
    }

    /**
     *
     * @param \Doctrine\ORM\EntityManagerInterface $em
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    public abstract function getRepository(EntityManagerInterface $em);
}