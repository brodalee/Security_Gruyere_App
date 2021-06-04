<?php

namespace App\Model\Repository;

use Core\Model\AbstractRepository;

class LikeDislikeSauceRepository extends AbstractRepository
{

    public function getLikeDislikeCount($sauceId)
    {
        return $this->customQuery("
            SELECT 
	            (SELECT COUNT(*) FROM User_Like_Dislike_Sauce WHERE kind = 'LIKE') as likes,
                (SELECT COUNT(*) FROM User_Like_Dislike_Sauce WHERE kind = 'DISLIKE') as dislikes
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
}