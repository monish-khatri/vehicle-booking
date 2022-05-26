<?php
session_start();
$userId = (int)$_SESSION['user']['id'];
include_once '../model/Vehicle.php';
$action = $_POST['action'];

switch($action){
    case 'book_vehicle':
        $vehicle = new Vehicle($userId);
        $error=[];
        $data = $_POST;
        if(empty($data['startDate']) || empty($data['endDate']) || (strtotime($data['startDate']) > strtotime($data['endDate'])))
        {
            $error = [];
            if(empty($data['startDate'])){
                $error['startDate'] = 'Start Date is Required.';
            }
            if(empty($data['endDate'])){
                $error['endDate'] = 'Start Date is Required.';
            }
            if (strtotime($data['startDate']) > strtotime($data['endDate'])) {
                $error['endDate'] = 'Start Date not be greater than End date.';
            }
            $response = [
                'success' => false,
                'validationError' => $error,
                'error' => true,
            ];
            break;
        }
        $available = $vehicle->checkAvaibility($_POST);
        if ($available){
            $response = $vehicle->bookVehicle($_POST);
        } else {
            $error['endDate'] = 'Vehicle is already booked for selected Date & time';
            $response = [
                'success' => false,
                'validationError' => $error,
                'error' => true,
            ];
        }
        break;
    case 'cancel_booking':
        $vehicle = new Vehicle($userId);
        $response = $vehicle->cancelBooking($_POST);
        break;
        
    default:
    $response = [
        'success'=>false,
        'message'=>'Invalid Request',
    ];
}

echo json_encode($response);
exit;