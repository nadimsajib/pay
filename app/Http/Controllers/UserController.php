<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{

    public function __construct( $userId ) {
        $this->userId = $userId;
    }
    private $userId;
    private $freeWithdraw = 3;
    public function isFreeWithdraw( $withdrawInWeekForPrivateUser ) {
        if ( count( $withdrawInWeekForPrivateUser ) > $this->freeWithdraw ) {
            return true;
        }
        return false;
    }

}