<?php

namespace App\Http\Controllers\Api;

use App\Helper\Response\Json;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PartnerRequest;
use App\Http\Resources\Api\PartnerResource;
use App\Models\Partner;

class PartnerController extends Controller
{

    /**
     * Display Partners.
     *
     * @OA\Get (
     * path="/api/partner",
     * summary="Get All his Partners",
     * description="Get All Auth's Partner",
     * operationId="my_partners",
     * tags={"Partner"},
     * security={{ "Bearer":{} }},
     * @OA\Response(
     *    response=200,
     *    description="Data Loaded Successfully",
     *    @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example=true),
     *       @OA\Property(property="message", type="string", example="Data loaded Successfully"),
     *       @OA\Property(property="data", type="array",
     *          @OA\Items(
     *              @OA\Property(property="partner_id", type="number", example="1"),
     *              @OA\Property(property="partner_name", type="string", example="Partner's Name"),
     *          )
     *       )
     *    )
     * )
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $partners = Partner::with('parent')->where('parent_id', auth()->id())->get();
        return Json::success('Data Loaded Successfully', PartnerResource::collection($partners));
    }

    /**
     * Add New Partner.
     *
     * @OA\Post (
     * path="/api/partner",
     * summary="Add New Partner",
     * description="Add New Partner",
     * operationId="new_partner",
     * tags={"Partner"},
     * security={{ "Bearer":{} }},
     * @OA\RequestBody(
     *    @OA\MediaType(mediaType="application/x-www-form-urlencoded",
     *      @OA\Schema(
     *           @OA\Property(property="partner_id", type="integer", example="1"),
     *      ),
     *    ),
     *    @OA\JsonContent(
     *      @OA\Property(property="partner_id", type="integer", example="1"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Added Successfully",
     *    @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example=true),
     *       @OA\Property(property="message", type="string", example="Partner Added Successfully")
     *    )
     * )
     * )
     *
     * @param PartnerRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PartnerRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $partner = Partner::create([
                'partner_id' => $request->partner_id,
                'parent_id' => auth()->id()
            ]);
            return Json::success('Partner Added Successfully', $partner);
        } catch (\Exception $exception) {
            return Json::error($exception->getMessage());
        }
    }
}
