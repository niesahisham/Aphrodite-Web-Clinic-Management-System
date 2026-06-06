<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        $patients = [
            [
                'patient_code' => 'P001',
                'full_name'    => 'Emma Wilson',
                'dob'          => '1992-03-15',
                'gender'       => 'Female',
                'phone'        => '0123456789',
                'address'      => 'No 12, Jalan Ampang, Kuala Lumpur',
                'blood_type'   => 'A+',
                'allergies'    => 'Penicillin, Sulfa drugs',
                'status'       => 'Active',
                'registered_by'=> null,
            ],
            [
                'patient_code' => 'P002',
                'full_name'    => 'James Brown',
                'dob'          => '1979-07-22',
                'gender'       => 'Male',
                'phone'        => '0198765432',
                'address'      => 'No 5, Jalan Bukit Bintang, Kuala Lumpur',
                'blood_type'   => 'B+',
                'allergies'    => null,
                'status'       => 'Active',
                'registered_by'=> null,
            ],
            [
                'patient_code' => 'P003',
                'full_name'    => 'Olivia Martinez',
                'dob'          => '1998-11-05',
                'gender'       => 'Female',
                'phone'        => '0112233445',
                'address'      => 'No 8, Jalan PJ, Petaling Jaya',
                'blood_type'   => 'O+',
                'allergies'    => 'Latex',
                'status'       => 'Active',
                'registered_by'=> null,
            ],
            [
                'patient_code' => 'P004',
                'full_name'    => 'William Taylor',
                'dob'          => '1974-05-18',
                'gender'       => 'Male',
                'phone'        => '0167894321',
                'address'      => 'No 20, Jalan Cheras, Kuala Lumpur',
                'blood_type'   => 'AB+',
                'allergies'    => null,
                'status'       => 'Active',
                'registered_by'=> null,
            ],
            [
                'patient_code' => 'P005',
                'full_name'    => 'Sophia Anderson',
                'dob'          => '1985-09-30',
                'gender'       => 'Female',
                'phone'        => '0134567890',
                'address'      => 'No 3, Jalan Duta, Kuala Lumpur',
                'blood_type'   => 'A-',
                'allergies'    => null,
                'status'       => 'Active',
                'registered_by'=> null,
            ],
        ];

        foreach ($patients as $patient) {
            Patient::create($patient);
        }
    }
}
