<?php

namespace App\Http\Requests;

use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'hotel_id' => [
                'required',
                'exists:hotels,id',
                $this->checkTotalRooms(),
            ],
            'room_type' => ['required', 'string', Rule::in(['ESTANDAR', 'JUNIOR', 'SUITE'])],
            'accommodation' => ['required', 'string', $this->getAccommodationRule()],
            'quantity' => 'required|integer|min:1',
        ];
    }

    private function checkTotalRooms()
    {
        return function ($attribute, $value, $fail) {
            $hotel = Hotel::findOrFail($value);
            $currentRoomsCount = Room::where('hotel_id', $value)->sum('quantity');
            $newRoomsCount = $currentRoomsCount + $this->input('quantity');

            if ($newRoomsCount > $hotel->total_rooms) {
                $fail("The total number of rooms ({$newRoomsCount}) would exceed the hotel's capacity ({$hotel->total_rooms}).");
            }
        };
    }

    private function getAccommodationRule()
    {
        return function ($attribute, $value, $fail) {
            $roomType = $this->input('room_type');
            $validAccommodations = $this->getValidAccommodations($roomType);

            if (!in_array($value, $validAccommodations)) {
                $fail("The selected accommodation is invalid for the room type $roomType.");
            }
        };
    }

    private function getValidAccommodations($roomType)
    {
        switch ($roomType) {
            case 'ESTANDAR':
                return ['SENCILLA', 'DOBLE'];
            case 'JUNIOR':
                return ['TRIPLE', 'CUADRUPLE'];
            case 'SUITE':
                return ['SENCILLA', 'DOBLE', 'TRIPLE'];
            default:
                return [];
        }
    }
}
