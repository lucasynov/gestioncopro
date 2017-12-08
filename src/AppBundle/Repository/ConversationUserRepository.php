<?php

namespace AppBundle\Repository;

use AppBundle\Entity\ConversationUser;


class ConversationUserRepository extends \Doctrine\ORM\EntityRepository
{


	public function getOurConversation($idUser){

			
	    $conn = $this->getEntityManager()->getConnection();

	    $sql = "SELECT id_conversation , c.name FROM `app_conversation` c , `user_conversation` u where  c.id = u.id_conversation and id_user = :idUser";
	    $stmt = $conn->prepare($sql);
	    $stmt->execute(['idUser' => $idUser]);


	    return $stmt->fetchAll();
	}



	public function insertConversationUser($idUser,$id_conversation){
		$conn = $this->getEntityManager()->getConnection();

		$conversationUser = new ConversationUser($idUser,$id_conversation);

		$sql = "INSERT INTO `user_conversation` (`id_user`, `id_conversation`) VALUES (".$idUser.",".$id_conversation.");";
		
		$stmt = $conn->prepare($sql);
	    $stmt->execute();
		
	  
	}
}
