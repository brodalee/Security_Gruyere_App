<?php

namespace App\Model\Repository;

use Core\Model\AbstractRepository;

class LikeDislikeSauceRepository extends AbstractRepository
{

    public function getLikeDislikeCount($sauceId)
    {
        return $this->customQuery("
            SELECT 
	            (SELECT COUNT(*) FROM User_Like_Dislike_Sauce WHERE kind = 'LIKE' AND sauceId = $sauceId) as likes,
                (SELECT COUNT(*) FROM User_Like_Dislike_Sauce WHERE kind = 'DISLIKE' AND sauceId = $sauceId) as dislikes
            FROM `{$this->tableName}`
            WHERE sauceId = $sauceId
        ")[0] ?? $this->defaultCountValue();
    }

    private function defaultCountValue() {
        $obj = new \stdClass();
        $obj->likes = 0;
        $obj->dislikes = 0;
        return $obj;
    }

    public function hasAlreadyLikedSauce($sauceId, $userId)
    {
        return count($this->customQuery("
            SELECT id 
            FROM User_Like_Dislike_Sauce
            WHERE 
                  kind = 'LIKE' 
                  AND
                  sauceId = $sauceId
                  AND
                  userId = $userId")) === 1;
    }

    public function addLikeToSauce(int $sauceId, int $userId)
    {
        return $this->createFrom([
            'sauceId' => $sauceId,
            'userId' => $userId,
            'kind' => 'LIKE'
        ]);
    }

    public function deleteLikeToSauce(int $sauceId, int $userId)
    {
        return $this->deleteByFields([
            'sauceId' => $sauceId,
            'userId' => $userId,
            'kind' => 'LIKE'
        ]);
    }

    public function hasAlreadyDislikedSauce($sauceId, $userId)
    {
        return count($this->customQuery("
            SELECT id 
            FROM User_Like_Dislike_Sauce
            WHERE 
                  kind = 'DISLIKE' 
                  AND
                  sauceId = $sauceId
                  AND
                  userId = $userId")) === 1;
    }

    public function addDislikeSauce(int $sauceId, int $userId)
    {
        return $this->createFrom([
            'sauceId' => $sauceId,
            'userId' => $userId,
            'kind' => 'DISLIKE'
        ]);
    }

    public function deleteDislikeSauce(int $sauceId, int $userId)
    {
        return $this->deleteByFields([
            'sauceId' => $sauceId,
            'userId' => $userId,
            'kind' => 'DISLIKE'
        ]);
    }
}