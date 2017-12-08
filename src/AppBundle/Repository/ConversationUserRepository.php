<?php

namespace AppBundle\Repository;


class ConversationUserRepository extends \Doctrine\ORM\EntityRepository
{


	public function getOurConversation($idUser){

			
	    $conn = $this->getEntityManager()->getConnection();

	    $sql = "SELECT id_conversation , c.name FROM `app_conversation` c , `user_conversation` u where id_user = :idUser";
	    $stmt = $conn->prepare($sql);
	    $stmt->execute(['idUser' => $idUser]);


	    return $stmt->fetchAll();

	}
}
