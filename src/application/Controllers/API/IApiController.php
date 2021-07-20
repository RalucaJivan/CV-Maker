<?php

namespace App\Controllers\API;

interface IApiController
{
    public function getAction($request, $response, $args);
    public function getAllAction($request, $response, $args);
    public function createAction($request, $response, $args);
    public function editAction($request, $response, $args);
    public function deleteAction($request, $response, $args);
}