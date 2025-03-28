<?php

namespace App\Repositories;

use App\Models\Reservation;
use App\Repositories\Interface\ReservationRepositoryInterface;

class ReservationRepository implements ReservationRepositoryInterface {
    public function create(array $data) {
        return Reservation::create($data);
    }

    public function getAll() {
        return Reservation::all();
    }

    public function getById($id) {
        return Reservation::findOrFail($id);
    }

    public function update($id, array $data) {
        $reservation = Reservation::findOrFail($id);
        $reservation->update($data);
        return $reservation;
    }

    public function delete($id) {
        return Reservation::destroy($id);
    }
    public function getByPlantId($plantId) {
        return Reservation::where('plant_id', $plantId)->get();
    }

    
}
