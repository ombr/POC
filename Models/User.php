<?php
namespace Models;
use Doctrine\ORM\Mapping as ORM;
use \Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
/**
 * @ORM\Entity()
 */
class User implements \MultiAuth\User{

	/**
	 * The id for all the entities.
     * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\generatedValue
	 */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="\Models\Provider")
     */
    private $providers;

    public function __construct(){
        $this->providers = new ArrayCollection();
    }

    public function getId(){
        return $this->id;
    }
    public function setId($Id){
        $this->Id=$Id;
        return $this;
    }
    public function addProvider($provider){
        $this->providers[] = $provider;
    }

    public function getProviders(){
        return $this->providers;
    }
    /*
     * @deprecated
     */
    public function setProviders($providers){
        $this->providers=$providers;
        return $this;
    }
    public function __toString(){
        if( $this->id === null){
            return 'undefined';
        }
        return $this->id.'';
    }
    
}
?>
