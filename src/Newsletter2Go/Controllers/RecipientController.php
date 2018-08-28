<?php

namespace Newsletter2Go\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Newsletter2Go\Models\Recipient;

class RecipientController extends Controller
{
	public function index(Request $request, Response $response)
	{
		return $response->withJson(Recipient::all());
	}
}
