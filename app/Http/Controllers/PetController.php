<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePetRequest;
use App\Http\Requests\UpdatePetRequest;
use App\Interfaces\PetRepositoryInterface;
use App\Classes\ApiResponseClass;
use App\Http\Resource\PetResource;
use Illuminate\Support\Facades\DB;
use App\Models\Pet;

class PetController extends Controller
{
    private PetRepositoryInterface $petRepositoryInterface;

    public function __construct(PetRepositoryInterface $petRepositoryInterface) {
        $this->petRepositoryInterface = $petRepositoryInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->petRepositoryInterface->index();

        return ApiResponseClass::sendResponse(PetResource::collection($data),'',200);
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
    public function store(StorePetRequest $request)
    {
        $details = [
            'name' => $request->name,
            'age' => $request->age,
            'breed' => $request->breed 
        ];
        DB::beginTransaction();
        try {
            $pet = $this->petRepositoryInterface->store($details);
            DB::commit();
            return ApiResponseClass::sendResponse(new PetResource($pet),'New pet added',201);
        }catch(\Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pet = $this->petRepositoryInterface->show($id);

        return ApiResponseClass::sendResponse(new PetResource($pet),'',200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pet $pet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePetRequest $request, $id)
    {
        $updateDetails = [
            'name' => $request->name,
            'age' => $request->age,
            'breed' => $request->breed
        ];
        DB::beginTransaction();
        try {
            $pet = $this->petRepositoryInterface->update($updateDetails,$id);
            DB::commit();
            return ApiResponseClass::sendResponse('Pet updated successfully','',201);
        }catch(\Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->petRepositoryInterface->delete($id);

        return ApiResponseClass::sendResponse('Pet deleted successfully','',204);
    }
}
