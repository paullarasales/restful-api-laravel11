<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Interfaces\StudentRepositoryInterface;
use App\Classes\ApiResponseClass;
use App\Http\Resource\StudentResource;
use Illuminate\Support\Facades\DB;
use App\Models\Student;

class StudentController extends Controller
{
    private StudentRepositoryInterface $studentRepositoryInterface;

    public function __construct(StudentRepositoryInterface $studentRepositoryInterface) {
        return $this->studentRepositoryInterface = $studentRepositoryInterface; 
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->studentRepositoryInterface->index();

        return ApiResponseClass::sendResponse(StudentResource::collection($data),'',200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        $details = [
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'lastname' => $request->lastname,
            'age' => $request->age
        ];
        DB::beginTransaction();
        try {
            $student = $this->studentRepositoryInterface->store($details);

            DB::commit();
            return ApiResponseClass::sendResponse(new StudentResource($details),'Successfully Added New Data',201);
        }catch(\Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $student = $this->studentRepositoryInterface->getById($id);

        return ApiResponseClass::sendResponse(new StudentResource($student),'',200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, $id)
    {
        $updateDetails = [
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'lastname' => $request->lastname,
            'age' => $request->age
        ];
        DB::beginTransaction();
        try {
            $student = $this->studentRepositoryInterface->update($updateDetails,$id);

            DB::commit();
            return ApiResposeClass::sendResponse('Student Update Success','',201);
        }catch(\Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->studentRepositoryInterface->delete($id);

        return ApiResponseClass::sendResponse('Student Delete Successful','',204);
    }
}
