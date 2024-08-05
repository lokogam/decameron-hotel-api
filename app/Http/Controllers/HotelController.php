<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;


/**
 * @OA\Tag(
 *     name="Hotels",
 *     description="Operations related to hotels"
 * )
 */

class HotelController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/hotels",
     *     summary="List all hotels",
     *     tags={"Hotels"},
     *     @OA\Response(
     *         response=200,
     *         description="A list of hotels",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Hotel")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $hotels = Hotel::with('rooms')->get();
        return response()->json($hotels);
    }

    /**
     * @OA\Post(
     *     path="/api/hotels",
     *     summary="Create a new hotel",
     *     tags={"Hotels"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/HotelRequest")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="The created hotel",
     *         @OA\JsonContent(ref="#/components/schemas/Hotel")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'nit' => 'required|string|max:255|unique:hotels',
            'total_rooms' => 'required|integer',
        ]);

        $hotel = Hotel::create($validatedData);
        return response()->json($hotel, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/hotels/{id}",
     *     summary="Get a specific hotel",
     *     tags={"Hotels"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the hotel",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Details of the specified hotel",
     *         @OA\JsonContent(ref="#/components/schemas/Hotel")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Hotel not found"
     *     )
     * )
     */
    public function show(string $id)
    {
        $hotel = Hotel::with('rooms')->findOrFail($id);
        return response()->json($hotel);
    }

    /**
     * @OA\Put(
     *     path="/api/hotels/{id}",
     *     summary="Update an existing hotel",
     *     tags={"Hotels"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the hotel",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/HotelRequest")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="The updated hotel",
     *         @OA\JsonContent(ref="#/components/schemas/Hotel")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Hotel not found"
     *     )
     * )
     */
    public function update(Request $request, string $id)
    {
        $hotel = Hotel::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'address' => 'string|max:255',
            'city' => 'string|max:255',
            'nit' => 'string|max:255|unique:hotels,nit,' . $hotel->id,
            'total_rooms' => 'integer',
        ]);

        $hotel->update($validatedData);
        return response()->json($hotel);
    }

    /**
     * @OA\Delete(
     *     path="/api/hotels/{id}",
     *     summary="Delete a hotel",
     *     tags={"Hotels"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the hotel",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Hotel deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Hotel deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Hotel not found"
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->delete();
        return response()->json(['message' => 'Hotel deleted successfully']);
    }
}
