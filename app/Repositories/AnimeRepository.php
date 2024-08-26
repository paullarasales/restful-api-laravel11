<?php

namespace App\Repositories;

use App\Models\Anime;
use App\Interfaces\AnimeRepositoryInterface;

class AnimeRepository implements AnimeRepositoryInterface
{
    public function index()
    {
        return Anime::limit(4)->get();
    }

    public function getById($id) 
    {
        return Anime::findOrFail($id);
    }

    public function store(array $data) 
    {
        return Anime::create($data);
    }

    public function update(array $data,$id) 
    {
        return Anime::findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        Anime::destroy($id);
    }
}
