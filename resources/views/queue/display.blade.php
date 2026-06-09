<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Queue Display Board - MediCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white min-h-screen">
    <div class="p-10">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-4xl font-bold">MediCare Queue Display</h1>
                <p class="text-gray-400 mt-2">Real-time patient queue status</p>
            </div>
            <div class="text-right">
                <p class="text-xl font-semibold">{{ now()->format('l, d F Y') }}</p>
                <p id="clock" class="text-gray-400"></p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white text-gray-800 rounded-2xl shadow p-6">
                <h2 class="text-2xl font-bold mb-4 text-blue-700">Now Calling</h2>
                <div id="calledList" class="space-y-4"></div>
            </div>

            <div class="bg-white text-gray-800 rounded-2xl shadow p-6">
                <h2 class="text-2xl font-bold mb-4 text-yellow-700">Waiting Queue</h2>
                <div id="waitingList" class="space-y-4"></div>
            </div>
        </div>
    </div>

    <script>
        function updateClock() {
            document.getElementById('clock').textContent = new Date().toLocaleTimeString();
        }

        function queueCard(item, isCalled = false) {
            return `
                <div class="border ${isCalled ? 'border-blue-200 bg-blue-50' : 'border-yellow-200 bg-yellow-50'} rounded-xl p-5 flex justify-between items-center">
                    <div>
                        <p class="text-3xl font-bold ${isCalled ? 'text-blue-700' : 'text-yellow-700'}">Q${item.queue_no}</p>
                        <p class="text-lg font-semibold mt-1">${item.patient_name}</p>
                        <p class="text-sm text-gray-500">Dr. ${item.doctor_name} | ${item.scheduled_time}</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-sm font-medium ${isCalled ? 'bg-blue-100 text-blue-700' : 'bg-yellow-100 text-yellow-700'}">
                        ${item.queue_status}
                    </span>
                </div>
            `;
        }

        function loadQueue() {
            fetch("{{ route('queue.board-data') }}")
                .then(response => response.json())
                .then(data => {
                    const called = data.filter(item => item.queue_status === 'Called');
                    const waiting = data.filter(item => item.queue_status === 'Waiting');

                    document.getElementById('calledList').innerHTML = called.length
                        ? called.map(item => queueCard(item, true)).join('')
                        : '<p class="text-gray-400 text-center py-10">No patient is being called.</p>';

                    document.getElementById('waitingList').innerHTML = waiting.length
                        ? waiting.map(item => queueCard(item)).join('')
                        : '<p class="text-gray-400 text-center py-10">No patients waiting.</p>';
                });
        }

        updateClock();
        loadQueue();
        setInterval(updateClock, 1000);
        setInterval(loadQueue, 7000);
    </script>
</body>
</html>