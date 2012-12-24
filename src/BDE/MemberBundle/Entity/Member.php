<?php

namespace BDE\MemberBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Member
 *
 * @ORM\Table(name="bde_member")
 * @ORM\Entity
 */
class Member
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
     * @ORM\ManyToOne(targetEntity="\BDE\MemberBundle\Entity\Student", inversedBy="member")
     */
    private $student;

    /**
     * @var integer
     *
     * @ORM\Column(name="year", type="integer")
     */
    private $year;

    /**
     * @var integer
     *
     * @ORM\Column(name="subscription", type="smallint")
     */
    private $subscription;

    /**
     * @var float
     *
     * @ORM\Column(name="sum", type="decimal")
     */
    private $sum;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    public function getCode($withKey = false)
    {
        return sprintf('%01d%06d', $this->getSubscription(), $this->getId()) . ($withKey ? $this->getKeyCode() : null);
    }

    public function getKeyCode() {
        $code = $this->getCode();
        $key = 0;
        for( $i = 0 ; $i < strlen($code) ; $i++ )
        {
            $key += $code[$i] * ($i%2 == 0 ? 3 : 1);
        }
        return 10 - $key%10;
    }

    /**
     * Set year
     *
     * @param integer $year
     * @return Member
     */
    public function setYear($year)
    {
        $this->year = $year;
    
        return $this;
    }

    /**
     * Get year
     *
     * @return integer 
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set subscription
     *
     * @param integer $subscription
     * @return Member
     */
    public function setSubscription($subscription)
    {
        $this->subscription = $subscription;
    
        return $this;
    }

    /**
     * Get subscription
     *
     * @return integer 
     */
    public function getSubscription()
    {
        return $this->subscription;
    }

    /**
     * Set sum
     *
     * @param float $sum
     * @return Member
     */
    public function setSum($sum)
    {
        $this->sum = $sum;
    
        return $this;
    }

    /**
     * Get sum
     *
     * @return float 
     */
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * Set student
     *
     * @param \BDE\MemberBundle\Entity\Student $student
     * @return Member
     */
    public function setStudent(\BDE\MemberBundle\Entity\Student $student = null)
    {
        $this->student = $student;
    
        return $this;
    }

    /**
     * Get student
     *
     * @return \BDE\MemberBundle\Entity\Student 
     */
    public function getStudent()
    {
        return $this->student;
    }
}