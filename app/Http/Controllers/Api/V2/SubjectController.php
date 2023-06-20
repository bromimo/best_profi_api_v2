<?php

namespace App\Http\Controllers\Api\V2;

use App\Models\Subject;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Services\CacheService;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubjectResource;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use Illuminate\Http\Resources\Json\JsonResource;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResource
    {
        return SubjectResource::collection(
            CacheService::getAll(function () {
                return Subject::paginate($this->paginate);
            })
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubjectRequest $request): JsonResource
    {
        $subject = Subject::create($request->validated());
        CacheService::forgetCache();

        return SubjectResource::make($subject->fresh());
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject): JsonResource
    {
        return SubjectResource::make($subject);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubjectRequest $request, Subject $subject): JsonResource
    {
        $subject->update($request->validated());
        CacheService::forgetCache();

        return SubjectResource::make($subject->fresh());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject): JsonResponse
    {
        $subject->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
