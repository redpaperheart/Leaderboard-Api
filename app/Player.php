<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Player extends Model
{
    protected $fillable = [
        'leaderboard',
        'name',
        'score',
        'image'
    ];

    //protected static $uploadBaseDir = 'data/images/';
    protected static $filenameLength = 8;

    /**
     * Creates a unique filename by appending a number
     *
     * i.e. if image.jpg already exists, returns
     * image2.jpg 
     */
    public static function getUniqueFilename($ext) {
        do{
            $name = str_slug( str_random(self::$filenameLength)).'.'.$ext;
        } while ( !Player::where('image', '=', $name )->get()->isEmpty() );
        
        return $name;
    }
}
