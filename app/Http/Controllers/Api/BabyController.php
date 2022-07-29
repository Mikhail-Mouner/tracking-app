<?php

namespace App\Http\Controllers\Api;

use App\Helper\Response\Json;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\BabyRequest;
use App\Http\Resources\Api\BabyResource;
use App\Http\Resources\Api\BabyWithParentResource;
use App\Models\Baby;
use App\Models\User;

class BabyController extends Controller
{
    /**
     * List All his babies with all his partner`s babies.
     *
     * @OA\Get (
     * path="/api/baby",
     * summary="Babies with all his partner`s babies",
     * description="List All his babies with all his partner`s babies",
     * operationId="partners_babies",
     * tags={"Baby"},
     * security={{ "Bearer":{} }},
     * @OA\Response(
     *    response=200,
     *    description="Data Loaded Successfully",
     *    @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example=true),
     *       @OA\Property(property="message", type="string", example="Data loaded Successfully"),
     *       @OA\Property(property="data", type="array",
     *          @OA\Items(
     *              @OA\Property(property="babies", type="array",
     *                  @OA\Items(
     *                      @OA\Property(property="baby_id", type="number", example="1"),
     *                      @OA\Property(property="baby_name", type="string", example="Baby's Name"),
     *                  )
     *              ),
     *              @OA\Property(property="partners_baby", type="array",
     *                  @OA\Items(
     *                      @OA\Property(property="baby_id", type="number", example="1"),
     *                      @OA\Property(property="baby_name", type="string", example="Baby's Name"),
     *                      @OA\Property(property="parent", type="string", example="Parent's Name"),
     *                  )
     *              ),
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
        $data = User::with('babies')->with('partners_baby.parent')->find(1);
        return Json::success('Data Loaded Successfully', [
            'babies' => BabyResource::collection($data->babies),
            'partners_baby' => BabyWithParentResource::collection($data->partners_baby),
        ]);
    }


    /**
     * Display Parent's Baby.
     *
     * @OA\Get (
     * path="/api/parent/babies",
     * summary="Parnet's Babies",
     * description="Get All Parnet's Babies",
     * operationId="my_babies",
     * tags={"Baby"},
     * security={{ "Bearer":{} }},
     * @OA\Response(
     *    response=200,
     *    description="Data Loaded Successfully",
     *    @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example=true),
     *       @OA\Property(property="message", type="string", example="Data loaded Successfully"),
     *       @OA\Property(property="data", type="array",
     *          @OA\Items(
     *              @OA\Property(property="baby_id", type="number", example="1"),
     *              @OA\Property(property="baby_name", type="string", example="Baby's Name"),
     *          )
     *       )
     *    )
     * )
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function myBaby(): \Illuminate\Http\JsonResponse
    {
        $data = auth()->user()->babies;
        return Json::success('Data Loaded Successfully', BabyResource::collection($data));
    }

    /**
     * Add New Baby.
     *
     * @OA\Post (
     * path="/api/baby",
     * summary="Add New Baby",
     * description="Add New Baby",
     * operationId="new_baby",
     * tags={"Baby"},
     * security={{ "Bearer":{} }},
     * @OA\RequestBody(
     *    @OA\MediaType(mediaType="application/x-www-form-urlencoded",
     *      @OA\Schema(
     *           @OA\Property(property="name", type="string", example="Baby's name"),
     *      ),
     *    ),
     *    @OA\JsonContent(
     *      @OA\Property(property="name", type="string", example="Baby's name"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Added Successfully",
     *    @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example=true),
     *       @OA\Property(property="message", type="string", example="Baby Added Successfully")
     *    )
     * )
     * )
     *
     * @param BabyRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(BabyRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $baby = Baby::create([
                'name' => $request->name,
                'parent_id' => auth()->id()
            ]);

            return Json::success('Baby Added Successfully', $baby);
        } catch (\Exception $exception) {
            return Json::error($exception->getMessage());
        }
    }

    /**
     * Display One Baby.
     *
     * @OA\Get (
     * path="/api/baby/{id}",
     * summary="Get a baby by ID",
     * description="Display One Baby By set id in url ",
     * operationId="one_baby",
     * tags={"Baby"},
     * security={{ "Bearer":{} }},
     * @OA\Parameter( name="id", in="path", required=true,
     *     @OA\Schema( type="integer", example="1")
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Data Loaded Successfully",
     *    @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example=true),
     *       @OA\Property(property="message", type="string", example="Data loaded Successfully"),
     *       @OA\Property(property="data", type="object",
     *          @OA\Property(property="baby_id", type="number", example="1"),
     *          @OA\Property(property="baby_name", type="string", example="Baby's Name"),
     *       )
     *    )
     * )
     * )
     *
     * @param \App\Models\Baby $baby
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Baby $baby): \Illuminate\Http\JsonResponse
    {
        return Json::success('Data Loaded Successfully', BabyResource::make($baby));
    }

    /**
     * Edit Baby's Name.
     *
     * @OA\Put (
     * path="/api/baby/{id}",
     * summary="Edit Baby's Name",
     * description="Edit Baby's Name",
     * operationId="edit_baby",
     * tags={"Baby"},
     * security={{ "Bearer":{} }},
     * @OA\Parameter( name="id", in="path", required=true,
     *     @OA\Schema( type="integer", example="1")
     * ),
     * @OA\RequestBody(
     *    @OA\MediaType(mediaType="application/x-www-form-urlencoded",
     *      @OA\Schema(
     *           @OA\Property(property="name", type="string", example="Baby's name Modified"),
     *      ),
     *    ),
     *    @OA\JsonContent(
     *      @OA\Property(property="name", type="string", example="Baby's name Modified"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Updated Successfully",
     *    @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example=true),
     *       @OA\Property(property="message", type="string", example="Baby Updated Successfully")
     *    )
     * )
     * )
     *
     * @param BabyRequest $request
     * @param \App\Models\Baby $baby
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(BabyRequest $request, Baby $baby): \Illuminate\Http\JsonResponse
    {
        try {
            $baby->update([
                'name' => $request->name,
            ]);

            return Json::success('Baby Updated Successfully', $baby);
        } catch (\Exception $exception) {
            return Json::error($exception->getMessage());
        }
    }

    /**
     * Delete One Baby.
     *
     * @OA\Delete (
     * path="/api/baby/{id}",
     * summary="Delete One Baby",
     * description="Delete One Baby",
     * operationId="delete_baby",
     * tags={"Baby"},
     * security={{ "Bearer":{} }},
     * @OA\Parameter( name="id", in="path", required=true,
     *     @OA\Schema( type="integer", example="1")
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Removed Successfully",
     *    @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example=true),
     *       @OA\Property(property="message", type="string", example="Baby Removed Successfully")
     *    )
     * )
     * )
     *
     * @param \App\Models\Baby $baby
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Baby $baby): \Illuminate\Http\JsonResponse
    {
        try {
            if (auth()->id() !== $baby->parent_id)
                throw new \Exception('Only His Parent Has Access To Delete This Baby');
            $baby->delete();

            return Json::success('Baby Removed Successfully');
        } catch (\Exception $exception) {
            return Json::error($exception->getMessage());
        }
    }
}
