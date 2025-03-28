<?php

namespace App\Http\Controllers;

use App\Repositories\Interface\ReservationRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    private $reservationRepository;

    public function __construct(ReservationRepositoryInterface $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
    }

    /**
     * Display a listing of all reservations.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservations = $this->reservationRepository->getAll();
        
        return response()->json([
            'status' => 'success',
            'data' => $reservations
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created reservation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Get the authenticated user
        // dd(Auth::user());
        // $user = Auth::user();
        
        $validatedData = $request->validate([
            'plant_id' => 'required|integer|exists:plantes,id',
        ]);
        // dd($request);

        
        $validatedData['user_id'] = 1;
        
        $validatedData['done'] = 0;

        $reservation = $this->reservationRepository->create($validatedData);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Reservation created successfully',
            'data' => $reservation
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified reservation.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $reservation = $this->reservationRepository->getById($id);
            
            // Check if the reservation belongs to the authenticated user
            if ($reservation->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized access'
                ], Response::HTTP_FORBIDDEN);
            }
            
            return response()->json([
                'status' => 'success',
                'data' => $reservation
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Reservation not found'
            ], Response::HTTP_NOT_FOUND);
        }
    }


    public function destroy($id)
    {
        try {
            $reservation = $this->reservationRepository->getById($id);
            if ($reservation->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized access'
                ], Response::HTTP_FORBIDDEN);
            }
            
            $this->reservationRepository->delete($id);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Reservation deleted successfully'
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Reservation not found'
            ], Response::HTTP_NOT_FOUND);
        }
    }

    public function myReservations()
    {
        $userId = 1;
        
        $reservations = $this->reservationRepository->getUserReservations($userId);
        
        return response()->json([
            'status' => 'success',
            'data' => $reservations
        ], Response::HTTP_OK);
    }

    public function getPlantReservations($plantId)
    {
        $reservations = $this->reservationRepository->getByPlantId($plantId);
        
        return response()->json([
            'status' => 'success',
            'data' => $reservations
        ], Response::HTTP_OK);
    }


    public function markAsDone($id)
    {
        try {
            // Get the reservation
            $reservation = $this->reservationRepository->getById($id);
            
            $updatedReservation = $this->reservationRepository->update($id, ['done' => 1]);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Reservation marked as done',
                'data' => $updatedReservation
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Reservation not found'
            ], Response::HTTP_NOT_FOUND);
        }
    }
}