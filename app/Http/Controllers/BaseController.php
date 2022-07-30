<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function index()
    {
        return view('index');
    }
    /**
     * From this get_file method the uploaded CSV file process and make decision to calculate commissions based on different rules
     *
     * @param Request $request  post request from frontend
     *
     * @author Nadimul Haque
     * @return String ($commissionFee)
     */

    public function get_file( Request $request ) {

        $commisionFee = new FeeCalculationController();
        $handle = fopen($_FILES["get_file"]["tmp_name"], 'r');

        $fileContent = array();
        while(!feof($handle)) {     
            $fpTotal = fgetcsv($handle);
            array_push($fileContent,$fpTotal);
        }
        fclose($handle);

        $withdrawInWeekForPrivateUser = [];
        for( $i = 0; $i < count( $fileContent ); $i++ ) {

            $row    = $fileContent[$i];
            $date   = date_format( date_create( $row[0] ) ,"Y-m-d");
            $year   = explode( '-', $date )[0];
            $isJanuary = ( date("m", strtotime( $date ) ) === '01' );
            $userId = $row[1];
            $kindOfUser             = $row[2];
            $kindOfCommissionFee    = $row[3];
            $value      = $row[4];
            $currency   = $row[5];

            $commissionFee = 0;
            $user = new UserController( $userId );
            if ( $kindOfUser === 'private' && $kindOfCommissionFee === 'withdraw' ) {
                // setWithdrawInWeekForPrivateUserByDate
                $commisionFee->setWithdrawInWeekForPrivateUserByDate( $userId, $date, $value, $currency );
                $withdrawInWeekForPrivateUser = $commisionFee->getWithdrawInWeekForPrivateUserByDate( $userId, $date );
                $lastWithdrawInWeekForPrivateUser = $withdrawInWeekForPrivateUser[ count( $withdrawInWeekForPrivateUser ) - 1 ];
                $exceeded1000 = $lastWithdrawInWeekForPrivateUser["exceeded1000"];
                /*check the month is december and check the last week or not. Because the years last week of december and first week of january in next year
                is same week within Monday to Sunday*/
                $firstWeekOnDecemberFromBeforeYearValueInEuro = $commisionFee->getWeekOnDecemberFromBeforeYearValueInEuro( $userId, $year - 1 );
                //Calculate Commission fee = 0.3% from withdrawn amount.
                if ( $user->isFreeWithdraw( $withdrawInWeekForPrivateUser ) ) {
                    $commissionFee = $value * 0.3 / 100;
                } else if ( $isJanuary && $exceeded1000 <= 1000 && $firstWeekOnDecemberFromBeforeYearValueInEuro > 1000 ) {
                    $commissionFee = $value * 0.3 / 100;
                } else if ( $exceeded1000 > 0 ) {
                    $commissionFee = $exceeded1000 * 0.3 / 100;
                } 
            } else if( $kindOfCommissionFee === 'deposit' ) {
                //All deposits are charged 0.03% of deposit amount.
                $commissionFee = $value * 0.03 / 100;
            } else if( $kindOfUser === 'business' ) {
                //Commission fee - 0.5% from withdrawn amount.
                $commissionFee = $value * 0.5 / 100;
            }
            echo '<pre>';
             print_r(round( $commissionFee, 2 ));
            echo '</pre>';

        }
        echo "successfully calculate commissions";

        //return view('index');

    }
}
