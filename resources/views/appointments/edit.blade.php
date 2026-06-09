@extends('layouts.app')

@section('title', 'Edit Appointment - MediCare')

@section('page-title', 'Edit Appointment')

@section('content')

    {{-- Error Messages --}}
    @if($errors->any())
    <div class="bg-red-100 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white rounded-xl shadow p-6 max-w-3xl">
        <form action="{{ route('appointments.update', $appointment) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Patient</label>
                <select name="patient_id" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}" {{ old('patient_id', $appointment->patient_id) == $patient->id ? 'selected' : '' }}>
                            {{ $patient->patient_code }} - {{ $patient->full_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Doctor</label>
                <select name="doctor_id" id="doctor_id" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}" {{ old('doctor_id', $appointment->doctor_id) == $doctor->id ? 'selected' : '' }}>
                            Dr. {{ $doctor->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Appointment Type</label>
                    <select name="appointment_type" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        @foreach(['Consultation', 'Follow-up', 'Emergency', 'Health Check'] as $type)
                            <option value="{{ $type }}" {{ old('appointment_type', $appointment->appointment_type) === $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date & Time</label>
                    <input type="datetime-local" name="scheduled_at" id="scheduled_at"
                        value="{{ old('scheduled_at', $appointment->scheduled_at->format('Y-m-d\TH:i')) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                    <p id="availabilityMessage" class="text-xs mt-1"></p>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                    @foreach(['confirmed', 'waiting', 'completed', 'cancelled'] as $status)
                        <option value="{{ $status }}" {{ old('status', $appointment->status) === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Reason</label>
                <input type="text" name="reason" value="{{ old('reason', $appointment->reason) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                <textarea name="notes" rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">{{ old('notes', $appointment->notes) }}</textarea>
            </div>

            <div class="flex gap-2">
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm font-medium">
                    Update Appointment
                </button>
                <a href="{{ route('appointments.index') }}"
                    class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 text-sm font-medium">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <script>
        const doctorInput = document.getElementById('doctor_id');
        const dateInput = document.getElementById('scheduled_at');
        const message = document.getElementById('availabilityMessage');

        function checkAvailability() {
            if (!doctorInput.value || !dateInput.value) return;

            fetch(`{{ route('appointments.availability') }}?doctor_id=${doctorInput.value}&scheduled_at=${dateInput.value}&appointment_id={{ $appointment->id }}`)
                .then(response => response.json())
                .then(data => {
                    message.textContent = data.message;
                    message.className = data.available ? 'text-xs mt-1 text-green-600' : 'text-xs mt-1 text-red-600';
                });
        }

        doctorInput.addEventListener('change', checkAvailability);
        dateInput.addEventListener('change', checkAvailability);
    </script>

@endsection