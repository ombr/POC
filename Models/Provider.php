<?php
namespace Models;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 */
class Provider{
	/**
	 * The id for all the entities.
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\generatedValue
	 */
    private $id;


    /**
	 * @ORM\Column(type="string")
     */
    private $providerId;

    /**
	 * @ORM\Column(type="string")
     */
    private $userId;

    /**
	 * @ORM\Column(type="string")
     */
    private $datas;


    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id=$id;
        return $this;
    }

    public function getProviderId(){
        return $this->providerId;
    }
    public function setProviderId($providerId){
        $this->providerId=$providerId;
        return $this;
    }
    public function getUserId(){
        return $this->userId;
    }
    public function setUserId($userId){
        $this->userId=$userId;
        return $this;
    }
    public function getDatas(){
        return $this->datas;
    }
    public function setDatas($datas){
        $this->datas=$datas;
        return $this;
    }

}
?>
