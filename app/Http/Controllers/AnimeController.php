<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnimeRequest;
use App\Http\Requests\UpdateAnimeRequest;
use App\Interfaces\AnimeRepositoryInterface;
use App\Classes\ApiResponseClass;
use App\Http\Resources\AnimeResource;
use Illuminate\Support\Facades\DB;
use App\Models\Anime;

class AnimeController extends Controller
{
    private AnimeRepositoryInterface $animeRepositoryInterface;

    public function __construct(AnimeRepositoryInterface $animeRepositoryInterface) {
        $this->animeRepositoryInterface = $animeRepositoryInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->animeRepositoryInterface->index();

        return ApiResponseClass::sendResponse(AnimeResource::collection($data),'',200);
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
    public function store(StoreAnimeRequest $request)
    {
        $details = [
            'title' => $request->title,
            'genre' => $request->genre
        ];
        DB::beginTransaction();
        try {
            $anime = $this->animeRepositoryInterface->store($details);
            DB::commit();
            return ApiResponseClass::sendResponse(new AnimeResource($anime),'New Anime Added',201);
        }catch(\Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $anime = $this->animeRepositoryInterface->getById($id);
        
        return ApiResponseClass::sendResponse(new AnimeResource($anime),'',200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Anime $anime)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAnimeRequest $request, $id)
    {
        $updateDetails = [
            'title' => $request->title,
            'genre' => $request->genre
        ];
        DB::beginTransaction();
        try {
            $anime = $this->animeRepositoryInterface->update($updateDetails,$id);
            DB::commit();
            return ApiResponseClass::sendResponse('Anime Updated Successful','',201);
        }catch(\Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->animeRepositoryInterface->delete($id);
        
        return ResponseClass::sendResponse('Anime Deleted Successfully','',204);
    }
}
