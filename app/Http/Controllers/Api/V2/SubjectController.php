<?php

namespace App\Http\Controllers\Api\V2;

use App\Models\Subject;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Services\CacheService;
use App\Http\Controllers\Controller;
use App\Http\Services\SubjectService;
use App\Http\Resources\SubjectResource;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use Illuminate\Http\Resources\Json\JsonResource;

class SubjectController extends Controller
{
    protected SubjectService $service;

    public function __construct(SubjectService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResource
    {
        return SubjectResource::collection(
            CacheService::getAll(function () {
                return Subject::with('phones')->paginate($this->paginate);
            })
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubjectRequest $request): JsonResource
    {
        $subject = $this->service->store($request->validated());

        return SubjectResource::make($subject);
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
        $subject = $this->service->update($subject, $request->validated());

        return SubjectResource::make($subject);
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
