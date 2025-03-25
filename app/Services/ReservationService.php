<?php

namespace App\Services;

use App\Repositories\ReservationRepositoryInterface;

class ReservationService {
    protected $reservationRepository;

    public function __construct(ReservationRepositoryInterface $reservationRepository ,PlantRepositoryInterface $plantRepository ) {
        $this->reservationRepository = $reservationRepository;
    }

    public function createReservation(array $data) {
        return $this->reservationRepository->create($data);
    }

    public function getAllReservations() {
        return $this->reservationRepository->getAll();
    }

    public function getReservationById($id) {
        return $this->reservationRepository->getById($id);
    }

    public function updateReservation($id, array $data) {
        return $this->reservationRepository->update($id, $data);
    }

    public function deleteReservation($id) {
        return $this->reservationRepository->delete($id);
    }

    public function Done($id){
        $data = ['done' => 1];
        $Reservation = Reservation::find($id);
        $this->reservationRepository->update($data);
    }
}
