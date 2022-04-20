<?php
namespace password_reset\Helper;
include __DIR__ . "/../Configuration/Configuration.php";



use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as Capsule;
use password_reset\Configuration\Configuration;

class Helper
{

  public static function headerLocation($results)
    {
        $data = Capsule::table('password_reset')->first();
        if ($data->is_active != 1) {
           return false;
        }
        if (!isset($_SESSION['uid'])) {
          return false;
        }
        if (!($_SERVER['REQUEST_URI'] != '/whm/index.php?rp=/user/password')) {
          return false;
        }
        if (!$results['customfields1'] == 'on') {
            header('Location: http://localhost/whm/index.php?rp=/user/password');
            exit();
        }
    }


    /**
     * @param $id
     */
    function getClientsDetails($id)
    {
        $postData = [
            'clientid' => $id,
            'stats' => true,
        ];
        $results = localAPI('GetClientsDetails', $postData);
        return $results;
    }


   public  function getClient($email)
    {
        $command = 'GetClients';
        $postData = array(
            'search' => $email,
        );
        $results = localAPI($command, $postData);
        if (empty($results['result']) && is_null($results['result'])) {

            return false;
        }
        if ($results['totalresults'] == 0) {

            return false;
        }

        return $results['clients']['client'][0];
    }


    /**
     * @param $datecreated
     * @param mixed $passwordexpired_at
     * @param $results
     * @return void
     */

    public function ifTheUserDoesNotResetThePasswordForTheLoad($datecreated,  $passwordexpired_at, $results)
    {
        if (Carbon::parse($datecreated)->diffInDays() > Configuration::THE_NUMBER_OF_DAYS_THE_PASSWORD_IS_RESET && is_null($passwordexpired_at)) {
            \password_reset\Helper\Helper::headerLocation($results);
        }
    }




    /**
     * @param int $passwordexpired_at
     * @param $results
     * @return void
     */
    function ifTheUserDoesNotResetThePassword( $passwordexpired_at, $results)
    {
        if ($passwordexpired_at > Configuration::THE_NUMBER_OF_DAYS_THE_PASSWORD_IS_RESET) {
            \password_reset\Helper\Helper::headerLocation($results);
        }
    }





}