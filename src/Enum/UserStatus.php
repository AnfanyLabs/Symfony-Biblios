<?php 
namespace App\Enum;

enum UserStatus:string {
    case Role_user = 'Utilisateur';
    case Role_admin = 'Administrateur';

    public function getLabel():string
    {
        return match ($this) {
            self::Role_user => 'Utilisateur' ,
            self::Role_admin => 'Administrateur',
        };
    }
}