<?php

namespace App\Repositories;

use App\Models\Student;
use App\Interfaces\StudentRepositoryInterface;

class StudentRepository implements StudentRepositoryInterface
{
    public function index()
    {
        return Student::all();
    }

    public function getById($id)
    {
        return Student::findOrFail($id);
    }

    public function store(array $data)
    {
        return Student::create($data);
    }

    public function update(array $data,$id)
    {
        return Student::whereId($id)->update($data);
    }

    public function delete($id) 
    {
        Student::destroy($id);
    }
}
