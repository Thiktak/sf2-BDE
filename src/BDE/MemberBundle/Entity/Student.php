<?php

namespace BDE\MemberBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Student
 *
 * @ORM\Table(name="student")
 * @ORM\Entity
 */
class Student
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\OneToMany(targetEntity="\BDE\MemberBundle\Entity\Member", mappedBy="student")
     * @ORM\OrderBy({"year" = "ASC"})
     */
    private $member;

    /**
     * @var string
     *
     * @ORM\Column(name="fname", type="string", length=255)
     */
    private $fname;

    /**
     * @var string
     *
     * @ORM\Column(name="lname", type="string", length=255)
     */
    private $lname;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime")
     */
    private $date_created;



    public function getAllMember() {
        $members = array();
        $min = 9999999999;
        $max = -$min;

        foreach( $this->getMember() as $entity ) {
            $min = min($min, $entity->getYear());
            $max = max($max, $entity->getYear()+$entity->getSubscription());

            for( $i = 0 ; $i < $entity->getSubscription() ; $i++ )
                $members[$entity->getYear() + $i] = array('is' => $i == 0 ? 2 : 1, 'entity' => $entity);
        }

        for( $i = $min ; $i < $max ; $i++ )
            if( !isset($members[$i]) )
                $members[$i] = array('is' => 0, 'entity' => null);
    
        ksort($members);
        //print_r($members);
        //exit();
        // */

        return $members;
    }

    public function getNbMember() {
        $members = array();
        $min = 9999999999;
        $max = -9999999999;

        foreach( $this->getMember() as $entity ) {
            $min = min($min, $entity->getYear());
            $max = max($max, $entity->getYear()+$entity->getSubscription());
        }

        return max($max - $min, 1);
    }

    public function __toString() {
        return trim(ucfirst($this->getLname() . ' ' . $this->getFname()));
    }

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
     * Set fname
     *
     * @param string $fname
     * @return Student
     */
    public function setFname($fname)
    {
        $this->fname = $fname;
    
        return $this;
    }

    /**
     * Get fname
     *
     * @return string 
     */
    public function getFname()
    {
        return $this->fname;
    }

    /**
     * Set lname
     *
     * @param string $lname
     * @return Student
     */
    public function setLname($lname)
    {
        $this->lname = $lname;
    
        return $this;
    }

    /**
     * Get lname
     *
     * @return string 
     */
    public function getLname()
    {
        return $this->lname;
    }

    /**
     * Set date_created
     *
     * @param \DateTime $dateCreated
     * @return Student
     */
    public function setDateCreated($dateCreated)
    {
        $this->date_created = $dateCreated;
    
        return $this;
    }

    /**
     * Get date_created
     *
     * @return \DateTime 
     */
    public function getDateCreated()
    {
        return $this->date_created;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->member = new \Doctrine\Common\Collections\ArrayCollection();
        $this->date_created = new \DateTime();
    }
    
    /**
     * Add member
     *
     * @param \BDE\MemberBundle\Entity\Member $member
     * @return Student
     */
    public function addMember(\BDE\MemberBundle\Entity\Member $member)
    {
        $this->member[] = $member;
    
        return $this;
    }

    /**
     * Remove member
     *
     * @param \BDE\MemberBundle\Entity\Member $member
     */
    public function removeMember(\BDE\MemberBundle\Entity\Member $member)
    {
        $this->member->removeElement($member);
    }

    /**
     * Get member
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMember()
    {
        return $this->member;
    }
}