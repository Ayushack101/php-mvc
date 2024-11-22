<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Core\Validator;
use App\Core\View;
use App\Exception\ValidationException;
use App\Models\User;

class HomeController extends Controller
{
    public User $user;

    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);
        $this->user = new User();
    }

    public function index()
    {
        $data = $this->getBody();
        $validator = new Validator();

        // Rules for validation
        $rules = [
            // 'name' => 'required|min:3|max:10',
            // 'email' => 'required|email',
            // 'phone' => 'required|numeric',
        ];

        try {
            $validator->validate($data, $rules);
            // $token = JwtFunctions::generate_jwt($user['id']);

            $this->user->all();

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