<?php

namespace App\Http\Controllers;

use App\Services\CreateTransferenceService;
use App\DTOs\CreateTransferenceDTO;
use App\Exceptions\ApplicationException;
use App\Http\Requests\CreateTransferenceRequest;
use Exception;

class CreateTransferenceController extends Controller
{
    public function __construct(
        private CreateTransferenceService $service
    ) {

    }

    public function __invoke(CreateTransferenceRequest $request)
    {
        try {
            $this->service->creatNewTransference(
                CreateTransferenceDTO::fromRequestValidated($request->validated())
            );

            return response()->json(['message' => 'Transference has created!'], 201);
        } catch (ApplicationException $applicationException) {
            return response()->json(['message' => $applicationException->getMessage()], $applicationException->getCode());
        } catch (\Exception $e) {
            return response()->json(['message' => 'Unknown error'], 500);
        }
    }
}
