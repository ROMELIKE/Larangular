<?php
namespace App\Business;
/**
 * Created by PhpStorm.
 * User: ROME
 * Date: 4/6/2017
 * Time: 3:44 PM
 */
class ResultObject
{
    //This class decides, the construct of basic ResultObject.
    //One return value of method, when call from controller, to model ussualy is object type
    public $message;
    public $messageCode;
    public $numberOfResult;
    public $result;
    public $info;
}
