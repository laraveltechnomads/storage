<?php
namespace App\Http\Traits;
use App\Models\Admin\PatientCategory;
use App\Models\API\V1\Patients\Appointment;
use App\Models\API\V1\Register\Registration;

trait PatientTrait {
    public function indexDetails() {
        // Fetch all the students from the 'student' table.
        return $registration = Registration::all();
    } 
}