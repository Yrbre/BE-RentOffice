<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\OfficeSpaceResource;
use App\Models\OfficeSpace;


class OfficeSpaceController extends Controller
{
    public function index()
    {
        $officeSpaces = OfficeSpace::with(['city'])->get();
        return OfficeSpaceResource::collection($officeSpaces);
    }

    public function show(OfficeSpace $officeSpace)
    {
        $officeSpace->load(['city', 'photos', 'benefits']);
        return new OfficeSpaceResource($officeSpace);
    }
}
