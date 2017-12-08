<?php

namespace AppBundle\Repository;


class MessageRepository extends \Doctrine\ORM\EntityRepository
{

	public function findByIdConversation($id_conversation){

		return $this->createQueryBuilder('m')
            ->where('m.id_conversation = :id_conversation')
            ->setParameter('id_conversation', $id_conversation)
            ->getQuery();
	}



}
