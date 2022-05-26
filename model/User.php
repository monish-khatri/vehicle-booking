<?php
session_start();

require_once 'DB.php';

class User
{
    private $db;

    public function __construct() {
		$this->db = new DB();
	}

    /**
     * Function will login the user
     *
     * @param array $requestData POST Data
     * 
     * @return array
     */
    public function login($requestData)
    {
        $response = [];
        try {
            $user = $this->db->query(
                'SELECT * FROM user WHERE username = ? AND password = ?',
                $requestData['username'],
                md5($requestData['password'])
            )->fetchArray();
            
            if (empty($user)){
                $response = [
                    'success'=>false,
                    'message'=>'Invalid Username or Password',
                ];
            } else {
                $_SESSION['user'] = $user;
                $response = [
                    'success'=>true,
                    'message'=>'Login Successfully',
                ];
            }
        }catch(Execption $e){
            $response = [
                'success'=>true,
                'message'=>'Something Went Wrong!',
            ];
        }
        

        return $response;
    }
    
    /**
     * Function will register the user
     *
     * @param array $requestData POST Data
     * 
     * @return array
     */
    public function register($requestData)
    {
        $response = [];
        try {
            $user = $this->db->query(
                'SELECT * FROM user WHERE username = ?',
                $requestData['username'],
            )->fetchArray();
            if (!empty($user)){
                $error['username'] = 'Username Already exists';

                $response = [
                    'success' => false,
                    'validationError' => $error,
                    'error' => true,
                ];
                return $response;
            }
            $insert = $this->db->query(
                'INSERT INTO user (username,first_name,last_name,password) VALUES (?,?,?,?)',
                $requestData['username'],
                $requestData['first_name'],
                $requestData['last_name'],
                md5($requestData['password']),
            );

            if ($insert->affectedRows() > 0){
                $response = [
                    'success'=>true,
                    'message'=>'Registeration Successfully',
                ];
            }
        }catch(Execption $e){
            $response = [
                'success'=>false,
                'message'=>'Something Went Wrong!',
            ];
        }
        return $response;
    }

    /**
     * Function will logout the user
     * 
     * @return bool
     */
    public function logout()
    {
        session_destroy();
        $response = [
            'success'=>true,
            'message'=>'Logout Successfully',
        ];
        return $response;
    }
    
}
