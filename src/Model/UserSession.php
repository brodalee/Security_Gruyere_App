<?php

namespace App\Model;

use App\Model\Entity\Success;
use Core\Interfaces\UserInterface;

class UserSession implements UserInterface
{
    private $id;
    private $role;
    private $pseudo;
    private $successes = [];

    static $SUCCESSES = [
        "SQL_INJECTION"     =>  [
            'Name'          => 'Injection SQL',
            'Description'   => "Vous avez réussi à vous connecter sans mot de passe."
        ],
        "ROUTE_ACCESS"      =>  [
            'Name'          =>  'Accès non autorisé',
            'Description'   =>  'Vous avez accédé à une route sans être connecté.'
        ],
        "UPLOAD"            =>  [
            'Name'          => 'Envois de script',
            'Description'   => 'Vous avez injecté un script executable via un envois de fichier.'
        ],
        "XSS"               => [
            'Name'          => 'XSS',
            'Description'   => 'Vous avez executé du code depuis une zone non protégé.'
        ],
        "INCLUDE"           =>  [
            'Name'          => 'Include',
            'Description'   => 'Vous avez executé du code depuis un fichier existant, importé, ou non sur le site.'
        ],
        "FORCE_BRUTE"       =>  [
            'Name'          => 'Attaque Force Brute',
            'Description'   => 'Vous avez forcé l\'entré jusqu\'a trouver la clé.'
        ],
        "LOGS_IN_FILE"      => [
            'Name'          => 'La Youtube / Vevo',
            'Description'   => 'Vous vous êtes connecté avec des logs en dur dans le code.'
        ]
    ];

    public function __construct($user = NULL, string $role = 'USER')
    {
        $this->role = $role;
        if ($user != NULL) {
            $this->pseudo = $user->pseudo;
            $this->id = $user->id;
        }
    }

    public function addSuccess(array $successName)
    {
        if (in_array($successName, static::$SUCCESSES) && !in_array($successName, $this->successes)) {
            $this->successes[] = $successName;
            $successRepository = (new Success())->getRepository();
            $successRepository->customQuery(
              "INSERT INTO `Success` (`id`, `name`, `description`) VALUES(NULL, '{$successName['Name']}', '{$successName['Description']}')"
            );
        }
        return $this;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->pseudo;
    }

    public function serialize()
    {
        return serialize([
            $this->id,
            $this->pseudo,
            $this->role,
            $this->successes
        ]);
    }

    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->pseudo,
            $this->role,
            $this->successes
            ) = unserialize($serialized, ["allowed_class" => false]);
    }
}