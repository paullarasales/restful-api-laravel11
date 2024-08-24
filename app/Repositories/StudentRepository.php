<?php

namespace App\Repositories;
use App\Models\Student;
use App\Interfaces\StudentRepositoryInterface;

class StudentRepository implements StudentRepositoryInterface
{
    public function index()
    {
        return Student::limit(4)->get();
    }

    public function getById($id)
    {
        return Product::findOrFail($id);
    }

    public function store(array $data)
    {
        return Product::create($data);
    }

    public function updata(array $data,$id)
    {
        return Student::whereIn($id)->update($data);
    }

    public function destroy($id) 
    {
        Student::destroy($id);
    }
}
