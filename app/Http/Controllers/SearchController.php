<?php

namespace App\Http\Controllers;

use App\Models\Packet;
use App\Models\Producer;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * @OA\Get(
     *   path="/search",
     *   summary="A list of most popular items",
     *   description="A list of most popular items",
     *   tags={"search"},
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="packets", type="array",
     *         @OA\Items(
     *           allOf={
     *             @OA\Schema(ref="#/components/schemas/Packet"),
     *           },
     *           @OA\Property(property="front", ref="#/components/schemas/Image"),
     *           @OA\Property(property="back", ref="#/components/schemas/Image"),
     *         ),
     *       ),
     *       @OA\Property(property="producers", type="array",
     *         @OA\Items(
     *           allOf={
     *             @OA\Schema(ref="#/components/schemas/Producer"),
     *           },
     *         ),
     *       ),
     *       @OA\Property(property="users", type="array",
     *         @OA\Items(
     *           allOf={
     *             @OA\Schema(ref="#/components/schemas/User"),
     *           },
     *         ),
     *       ),
     *     ),
     *   ),
     * )
     */
    public function index()
    {
        return new JsonResponse('Najczęściej wyszukiwane', 200);
    }

    /**
     * @OA\Get(
     *   path="/search/{search}",
     *   summary="A list of found items",
     *   description="A list of found items",
     *   tags={"search"},
     *   @OA\Parameter(
     *     in="path",
     *     name="search",
     *     required=true,
     *     @OA\Schema(
     *       type="string",
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="packets", type="array",
     *         @OA\Items(
     *           allOf={
     *             @OA\Schema(ref="#/components/schemas/Packet"),
     *           },
     *           @OA\Property(property="front", ref="#/components/schemas/Image"),
     *           @OA\Property(property="back", ref="#/components/schemas/Image"),
     *         ),
     *       ),
     *       @OA\Property(property="producers", type="array",
     *         @OA\Items(
     *           allOf={
     *             @OA\Schema(ref="#/components/schemas/Producer"),
     *           },
     *         ),
     *       ),
     *       @OA\Property(property="users", type="array",
     *         @OA\Items(
     *           allOf={
     *             @OA\Schema(ref="#/components/schemas/User"),
     *           },
     *         ),
     *       ),
     *     ),
     *   ),
     * )
     */
    public function show(string $search)
    {
        $foundProducers = Producer::where('name', 'LIKE', '%' . $search . '%')
            ->orWhere('desc', 'LIKE', '%' . $search . '%')
            ->orWhere('country', 'LIKE', '%' . $search . '%')
            ->get();

        $foundPackets = Packet::where('name', 'LIKE', '%' . $search . '%')
            ->orWhere('desc', 'LIKE', '%' . $search . '%')
            ->orWhere('name_polish', 'LIKE', '%' . $search . '%')
            ->orWhere('name_latin', 'LIKE', '%' . $search . '%')
            ->with('front')
            ->with('back')
            ->get();

        $foundUsers = User::where('name', 'LIKE', '%' . $search . '%')
            ->get();

        $searchResults = [
            'producers' => $foundProducers,
            'packets' => $foundPackets,
            'users' => $foundUsers,
        ];

        return new JsonResponse($searchResults, 200);
    }
}
