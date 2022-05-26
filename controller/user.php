<?php
require_once '../model/User.php';
$action = $_POST['action'];
switch ($action) {
    case 'login':
        $user = new User();
        $data = $_POST;
        if(empty($data['username']) || empty($data['password']))
        {
            $error = [];
            if(empty($data['username'])){
                $error['username'] = 'Username is Required.';
            }
            if(empty($data['password'])){
                $error['password'] = 'Password is Required.';
            }
            $response = [
                'success' => false,
                'validationError' => $error,
                'error' => true,
            ];
            break;
        }

        $response = $user->login($data);
        break;
    case 'register':
        $user = new User();
        $data = $_POST;
        $username = trim($data['username']);
        $password = trim($data['password']);
        $firstName = trim($data['first_name']);
        $lastName = trim($data['last_name']);
        $confirmPassword = trim($data['confirm-password']);
        if(empty($username) || empty($password) || empty($firstName) ||  empty($lastName) || empty($confirmPassword))
        {
            $error = [];
            if(empty($username)){
                $error['username'] = 'Username is Required.';
            }
            if(empty($firstName)){
                $error['first_name'] = 'First name is Required.';
            }
            if(empty($lastName)){
                $error['last_name'] = 'Last name is Required.';
            }
            if(empty($password)){
                $error['password'] = 'Password is Required.';
            }
            if(empty($confirmPassword)){
                $error['confirm-password'] = 'Confirm Password is Required.';
            }
        }
        if(! empty($password) && !empty($confirmPassword)){
            if ($password != $confirmPassword){
                $error['confirm-password'] = 'Confirm Password not match.';
            }
        }
        if(!empty($error)){
            $response = [
                'success' => false,
                'validationError' => $error,
                'error' => true,
            ];
            break;
        }

        $response = $user->register($data);
        break;
    case 'logout':
        $user = new User();
        $response = $user->logout();
        break;
    default:
        $response = [
            'success' => false,
            'message' => 'Invalid Request'
        ];
}

echo json_encode($response);
    ?>