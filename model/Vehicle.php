<?php
session_start();
include_once 'DB.php';
// use /Vehicle/DB;
/**
 * Example_Class is a sample class for demonstrating PHPDoc
 *
 * Example_Class is a class that has no real actual code, but merely
 * exists to help provide people with an understanding as to how the
 * various PHPDoc tags are used.
 *
 *
 * @package  Example
 * @author   Monish Khatri  <author@email.com>
 * @author   Adam Trachtenberg &lt;adam@example.com&gt;
 * @version  Revision: 1.3 $
 * @access   public
 * @see      http://www.example.com/pear
 */
class Vehicle {
    private $db;
    private $userId;
    public function __construct($userId = null) {
		$this->db = new DB();
		$this->userId = $userId;
	}

    /**
     * Function will get list of all vehicle available
     *
     * @return array
     */
    public function get()
    {
        $vehicle = $this->db->query('SELECT * FROM vehicle ORDER BY id DESC')->fetchAll();
        return $vehicle;
    }
    /**
     * Function will check the availiblity of vehicle
     *
     * @param array  $requestData POST Data
     *
     * @return bool
     */
    public function checkAvaibility($requestData)
    {
        $vehicle = $this->db->query('SELECT * FROM user_vehicle WHERE vehicle_id=?',$requestData['vehicleId'])->fetchAll();
        $available = true;
        foreach($vehicle as $key => $value){
            if ((int) strtotime($requestData['startDate']) >= $value['start_date'] && (int) strtotime($requestData['startDate']) <= $value['end_date'])
            {
                $available = false;
                break;
            } 
        }

        return $available;
    }

    /**
     * Function will book vehicle
     *
     * @param array $requestData POST Data
     *
     * @return array
     */
    public function bookVehicle($requestData)
    {
        $insert = $this->db->query(
            'INSERT INTO user_vehicle (user_id,vehicle_id,start_date,end_date) VALUES (?,?,?,?)',
            $this->userId,
            $requestData['vehicleId'],
            strtotime($requestData['startDate']),
            strtotime($requestData['endDate']),
        );
        if($insert->affectedRows() > 0){
            $response = [
                'success'=>true,
                'message'=> 'Vehicle Booked Successfully!'
            ];
        } else {
            $response = [
                'success'=>false,
                'message'=> 'Something Went Wrong!'
            ];
        }
        return $response;
    }

    /**
     * Function will book vehicle for logged in user
     *
     * @return array
     */
    public function bookedVehicle()
    {
        $vehicle = $this->db->query('SELECT vehicle.*,user_vehicle.id as vs_id FROM user_vehicle INNER JOIN vehicle ON vehicle.id=user_vehicle.vehicle_id WHERE user_vehicle.user_id=? ORDER BY user_vehicle.id DESC',$this->userId)->fetchAll();
        return $vehicle;
    }

     /**
     * Function will cancel vehicle booking
     *
     * @param array $requestData POST Data
     *
     * @return array
     */
    public function cancelBooking($requestData)
    {
        $vehicle = $this->db->query('DELETE FROM user_vehicle WHERE id=?',$requestData['vehicleUserId']);
        if($vehicle->affectedRows() > 0){
            $response = [
                'success'=>true,
                'message'=> 'Booking Canceled Successfully!'
            ];
        } else {
            $response = [
                'success'=>false,
                'message'=> 'Something Went Wrong!'
            ];
        }
        return $response;   
    }
}