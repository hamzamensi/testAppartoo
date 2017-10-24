<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class Insecte extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
   
     * @ORM\Column(type="integer")
     
     */
    protected $age;
    /**
     
     * @ORM\Column(type="string")
     
     */
    protected $famille;
    /**
    
     * @ORM\Column(type="string")
     
     */
    protected $race;
    /**
    
     * @ORM\Column(type="string")
     
     */
    protected $norriture;
    /**
     * @ORM\ManyToMany(targetEntity="Insecte", mappedBy="myFriends")
     */
    private $friendsWithMe;

    /**
     * 
     * @ORM\ManyToMany(targetEntity="Insecte", inversedBy="friendsWithMe")
     * @ORM\JoinTable(name="freinds",
     *      joinColumns={@ORM\JoinColumn(name="insect_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="friend_insect_id", referencedColumnName="id")}
     *      )
     */
    private $myFriends;

    
    public function __construct()
    {
        parent::__construct();
         $this->friendsWithMe = new \Doctrine\Common\Collections\ArrayCollection();
         $this->myFriends = new \Doctrine\Common\Collections\ArrayCollection();
        // your own logic
    }

    /**
     * Set age
     *
     * @param integer $age
     *
     * @return Insecte
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return integer
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set famille
     *
     * @param string $famille
     *
     * @return Insecte
     */
    public function setFamille($famille)
    {
        $this->famille = $famille;

        return $this;
    }

    /**
     * Get famille
     *
     * @return string
     */
    public function getFamille()
    {
        return $this->famille;
    }

    /**
     * Set race
     *
     * @param string $race
     *
     * @return Insecte
     */
    public function setRace($race)
    {
        $this->race = $race;

        return $this;
    }

    /**
     * Get race
     *
     * @return string
     */
    public function getRace()
    {
        return $this->race;
    }

    /**
     * Set norriture
     *
     * @param string $norriture
     *
     * @return Insecte
     */
    public function setNorriture($norriture)
    {
        $this->norriture = $norriture;

        return $this;
    }

    /**
     * Get norriture
     *
     * @return string
     */
    public function getNorriture()
    {
        return $this->norriture;
    }

    /**
     * Add friendsWithMe
     *
     * @param \AppBundle\Entity\Insecte $friendsWithMe
     *
     * @return Insecte
     */
    public function addFriendsWithMe(\AppBundle\Entity\Insecte $friendsWithMe)
    {
        $this->friendsWithMe[] = $friendsWithMe;

        return $this;
    }

    /**
     * Remove friendsWithMe
     *
     * @param \AppBundle\Entity\Insecte $friendsWithMe
     */
    public function removeFriendsWithMe(\AppBundle\Entity\Insecte $friendsWithMe)
    {
        $this->friendsWithMe->removeElement($friendsWithMe);
    }

    /**
     * Get friendsWithMe
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFriendsWithMe()
    {
        return $this->friendsWithMe;
    }

    /**
     * Add myFriend
     *
     * @param \AppBundle\Entity\Insecte $myFriend
     *
     * @return Insecte
     */
    public function addMyFriend(\AppBundle\Entity\Insecte $myFriend)
    {
        $this->myFriends[] = $myFriend;

        return $this;
    }

    /**
     * Remove myFriend
     *
     * @param \AppBundle\Entity\Insecte $myFriend
     */
    public function removeMyFriend(\AppBundle\Entity\Insecte $myFriend)
    {
        $this->myFriends->removeElement($myFriend);
    }

    /**
     * Get myFriends
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMyFriends()
    {
        return $this->myFriends;
    }
}
