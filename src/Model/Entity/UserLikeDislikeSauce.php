<?php

namespace App\Model\Entity;

use Core\Model\AbstractEntity;

class UserLikeDislikeSauce extends AbstractEntity
{

    static $KIND = [
        'LIKE'      => 'LIKE',
        'DISLIKE'   => 'DISLIKE'
    ];

    public $id;
    public $userId;
    public $kind;
    public $sauceId;

    public function __construct()
    {
        $this->tableName = "User_Like_Dislike_Sauce";
    }
}