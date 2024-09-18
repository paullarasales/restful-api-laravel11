<?php

namespace App\Repositories;
use App\Models\Pet;
use App\Interfaces\PetRepositoryInterface;

class PetRepository implements PetRepositoryInterface
{
   public function index()
   {
        return Pet::limit(5)->get();
   }

   public function getById($id)
   {
        return Pet::findOrFail($id);
   }

   public function store(array $data)
   {
        return Pet::create($data);
   }

   public function update(array $data, $id) 
   {
        return Pet::findOrFail($id)->update($data);
   }

   public function delete($id) 
   {
        Pet::destroy($id);
   }
}
