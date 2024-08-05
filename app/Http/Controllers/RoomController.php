<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomRequest;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * @OA\Tag(
 *     name="Rooms",
 *     description="Operations related to rooms"
 * )
 */
class RoomController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/rooms",
     *     summary="List all rooms",
     *     tags={"Rooms"},
     *     @OA\Response(
     *         response=200,
     *         description="A list of rooms",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Room")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $rooms = Room::with('hotel')->get();
        return response()->json($rooms);
    }

    /**
     * @OA\Post(
     *     path="/api/rooms",
     *     summary="Create a new room",
     *     tags={"Rooms"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/RoomRequest")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="The created room",
     *         @OA\JsonContent(ref="#/components/schemas/Room")
     *     )
     * )
     */
    public function store(RoomRequest $request)
    {

        $validatedData = $request->validated();

        DB::beginTransaction();
        try {
            $room = Room::create($validatedData);
            DB::commit();
            return response()->json($room, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error creating room: ' . $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/rooms/{id}",
     *     summary="Get a specific room",
     *     tags={"Rooms"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the room",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Details of the specified room",
     *         @OA\JsonContent(ref="#/components/schemas/Room")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Room not found"
     *     )
     * )
     */
    public function show(string $id)
    {
        $room = Room::with('hotel')->findOrFail($id);
        return response()->json($room);
    }

    /**
     * @OA\Put(
     *     path="/api/rooms/{id}",
     *     summary="Update an existing room",
     *     tags={"Rooms"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the room",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/RoomRequest")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="The updated room",
     *         @OA\JsonContent(ref="#/components/schemas/Room")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Room not found"
     *     )
     * )
     */
    public function update(RoomRequest $request, string $id)
    {
        $room = Room::findOrFail($id);
        $validatedData = $request->validated();
        $room->update($validatedData);
        return response()->json($room);
    }

    /**
     * @OA\Delete(
     *     path="/api/rooms/{id}",
     *     summary="Delete a room",
     *     tags={"Rooms"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the room",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Room deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Room deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Room not found"
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $room = Room::findOrFail($id);
        $room->delete();
        return response()->json(['message' => 'Room deleted successfully']);
    }
}
