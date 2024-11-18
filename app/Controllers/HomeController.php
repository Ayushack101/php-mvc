<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\DB;
use App\Core\Validator;
use App\Core\View;
use App\Exception\ValidationException;

class HomeController extends Controller
{
    public function index()
    {
        $data = $this->getBody();
        $validator = new Validator();

        $rules = [
            // 'name' => 'required|min:3|max:10',
            // 'email' => 'required|email',
            // 'phone' => 'required|numeric',
        ];

        try {
            $validator->validate($data, $rules);
            // $token = JwtFunctions::generate_jwt($user['id']);

            $this->jsonResponse(['message' => 'User created successfully'], 200);
        } catch (ValidationException $e) {
            $errors = $e->getErrors();
            $this->jsonResponse(['errors' => $errors, 'message' => $e->getMessage()], 422);
        }

        return $this->jsonResponse($data, 200);
        // return View::make('index', ['name' => 'Ayush']);
    }

    public function add()
    {
        $data = $this->getBody();
        // $name = $data['name'];
        return $this->jsonResponse($data, 200);
    }
}