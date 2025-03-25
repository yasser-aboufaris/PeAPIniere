<?php

namespace App\Http\Controllers;

use App\Services\ReservationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    protected $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id', 
            'plant_id' => 'required|exists:plants,id', 
            'done' => 'required|boolean', 
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->only(['user_id', 'plant_id', 'done']);
        $reservation = $this->reservationService->createReservation($data);
        return response()->json($reservation, 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'sometimes|required|exists:users,id',
            'plant_id' => 'sometimes|required|exists:plants,id',
            'done' => 'sometimes|required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->only(['user_id', 'plant_id', 'done']); 
        $reservation = $this->reservationService->updateReservation($id, $data);
        return response()->json($reservation);
    }

    public function index()
    {
        $reservations = $this->reservationService->getAllReservations();
        return response()->json($reservations);
    }

    public function show($id)
    {
        $reservation = $this->reservationService->getReservationById($id);
        return response()->json($reservation);
    }

    public function destroy($id)
    {
        $this->reservationService->deleteReservation($id);
        return response()->json(['message' => 'Reservation deleted successfully']);
    }

    public function markAsDone($id)
    {
        $this->reservationService->Done($id);
        return response()->json(['message' => 'Reservation marked as done']);
    }
}
