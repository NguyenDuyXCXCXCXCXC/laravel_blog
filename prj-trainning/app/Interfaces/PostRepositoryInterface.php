<?php

namespace App\Interfaces;

interface PostRepositoryInterface
{
    public function getAllPost($request, $active = null);
    public function getAllPostById($id);
}
