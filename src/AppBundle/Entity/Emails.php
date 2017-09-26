<?php 
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="crawlEmails")
 */
class Emails
{
     /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
     private $id;
      /**
     * @ORM\Column(type="string", length=100)
     */
    private $url;
     /**
     * @ORM\Column(type="string", length=30)
     */
    private $email;

    
    //GetEmails
    public function getEmail(){
        return $this->email;
    }
    //GetUrls
    public function getUrl(){
        return $this->url;
    }
    

}
