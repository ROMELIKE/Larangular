<?php
namespace App\Business;

/**
 * Created by PhpStorm.
 * User: ROME
 * Date: 4/6/2017
 * Time: 3:44 PM
 */
class MemberObject
{
    //This class decides, the construct of basic UserObject.
    //One return value of method, when call from controller, to model ussualy is object type
    public $id;
    public $email;
    public $name;
    public $status;
    public $avatar;
    public $age;
    public $address;
    public $created_at;
    public $updated_at;

}
