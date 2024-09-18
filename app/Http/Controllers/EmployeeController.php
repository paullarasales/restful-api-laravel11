<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Interfaces\EmployeeRepositoryInterface;
use use\Classes\ApiResponseClass;
use App\Http\Resources\EmployeeResource;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;

class EmployeeController extends Controller
{
    private EmployeeRepositoryInterface $employeeRepositoryInterface;

    public function __construct(EmployeeRepositoryInterface $employeeRepositoryInyterface) {
        $this->employeeRepositoryInterface = $employeeRepositoryInterface;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->employeeRepositoryInterface->index();

        return ApiResponseClass::sendResponse(EmployeeResource::collection($data),'',200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        $details = [
            'name' => $request->name,
            'age' => $request->age,
            'position' => $request->position
        ];
        DB::beginTrasaction();
        try {
            $employee = $this->employeeRepositoryInterface->store($details);
            DB::commit();
            return ApiResponseClass::sendResponse(new EmployeeResource($employee),'Employee added',201);
        }catch(\Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $employee = $this->employeeRepositoryInterface->getById($id);

        return ApiResponseClass::sendResponse(new EmployeeResource($employee),'',200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
