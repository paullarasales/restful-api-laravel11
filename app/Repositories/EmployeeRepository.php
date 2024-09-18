<?php

namespace App\Repositories;

use App\Interfaces\EmployeeRepositoryInterface;
use App\Models\Employee;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    public function index()
    {
        return Employee::all();
    }

    public function show($id)
    {
        return Employee::findOrFail($id);
    }

    public function store(array $data)
    {
        return Employee::create($data);
    }

    public function update(array $data, $id)
    {
        return Employee::findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        Employee::destroy($id);
    }
}
