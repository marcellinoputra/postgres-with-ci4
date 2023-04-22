<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\AdminModels;

class AuthController extends ResourceController
{
    use ResponseTrait;

    public function getAdminData()
    {
        $adminModel = new AdminModels();
        $result = $adminModel->findAll();
        if ($result) {
            $response = [
                "status" => 200,
                "data" => $result,
                "message" => "Successfully Get Admin Data"
            ];
            return $this->respond($response);
        } else {
            $response = [
                "status" => 400,
                'errors' => true,
                "message" => "Failed Get Admin Data"
            ];
            return $this->respond($response, 400);
        }
    }

    public function signUp()
    {
        $rules = [
            'name' => "required|min_length[5]",
            'username' => "required|min_length[5]",
            'password' => "required|min_length[8]"
        ];

        $message = [
            'name' => [
                'required' => 'Name is Required'
            ],
            'username' => [
                'required' => 'Username is Required'
            ],
            'password' => [
                'required' => 'Passowrd is Required'
            ]
        ];

        $password = password_hash($this->request->getVar('password'), PASSWORD_BCRYPT);
        if (!$this->validate($rules, $message)) {
            $response = [
                'status' => 400,
                'error' => true,
                'message' => $this->validator->getErrors(),
                'data' => []
            ];
            return $this->respond($response);
        } else {
            $adminModel = new AdminModels();
            $data = [
                'name' => $this->request->getVar('name'),
                'username' => $this->request->getVar('username'),
                'password' => $password
            ];
            $result = $adminModel->save($data);


            if ($result) {
                $response = [
                    "status" => 201,
                    "message" => "Successfully SignUp",
                    "password" => $password
                ];
                return redirect()->to("/login");
                return $this->respond($response);
            } else {
                $response = [
                    "status" => 400,
                    "message" => "Failed SignUp"
                ];
                return $this->respond($response, 400);
            }
        }
    }

    public function signIn()
    {
        $adminModel = new AdminModels();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $findUsers = $adminModel->where("username", $username)->first();
        $authVerif = password_verify($password, $findUsers['password']);

        // $key = getenv('JWT_SECRET');
        // $iat = time();
        // $exp = $iat + 3600;

        // $payload = array(
        //     "iss" => "Issuer of the JWT",
        //     "aud" => "Audience that the JWT",
        //     "sub" => "Subject of the JWT",
        //     "iat" => $iat, //Time the JWT issued at
        //     "exp" => $exp, // Expiration time of token
        //     "username" => $findUsers['username'],
        //     "password" => $findUsers['password']
        // );

        // $token = JWT::encode($payload, $key, 'HS256');
        if ($authVerif) {
            $response = [
                "status" => 200,
                "data" => [
                    'id' => $findUsers['id'],
                    'name' => $findUsers['name'],
                    'username' => $findUsers['username'],
                    'password' => $findUsers['password']
                ],
                "mesasge" => "Successfully Retrieve Data"
            ];
            return redirect()->to("/dashboard");
            // return $this->respond($response);
        } else {
            $response = [
                "mesasge" => "Wrong Password"
            ];
            return $this->respond($response, 400);
            // return $this->validator->getErrors();
        }
    }
}
