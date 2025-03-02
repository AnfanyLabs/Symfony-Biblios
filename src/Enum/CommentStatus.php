<?php 
namespace App\Enum;

enum CommentStatus:string {
    case Pending = 'En suspension';
    case Published = 'Publié';
    case Moderated = 'Modéré';


    public function getLabel(): string {
        return  match ($this) {
            self::Pending => 'En suspension' ,
            self::Published => 'Publié' ,
            self::Moderated => 'Modéré',
        };
    }

}
