<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Schedules') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                    <thead class="bg-gray-800 text-white">
                    <tr class="text-center">
                        <th class="px-4 py-2">Subject</th>
                        <th class="px-4 py-2">Room</th>
                        <th class="px-4 py-2">Time</th>
                        <th class="px-4 py-2">Day</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                    </thead>
                    <tbody class="text-gray-700">
                    @foreach ($schedules as $schedule)
                        <tr class="text-center">
                            <td class="px-4 py-2">{{ $schedule->subject->name }}</td>
                            <td class="px-4 py-2">{{ $schedule->room->room_number }}
                                - {{ $schedule->room->building_number }}</td>
                            <td class="px-4 py-2">{{ $schedule->time }}</td>
                            <td class="px-4 py-2">{{ $schedule->day }}</td>
                            <td class="px-4 py-2">
                                <button
                                    class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline cursor-pointer"
                                    onclick="openModal('{{ $schedule->id }}')">File a Leave
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="myModal"
         class="modal fixed w-full h-full top-0 left-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
        <!-- Modal content -->
        <div class="modal-content bg-white w-1/2 rounded-lg shadow-lg p-8 relative">
            <button class="close absolute top-0 right-0 px-4 py-2 text-lg cursor-pointer">&times;</button>
            <form id="leaveForm" class="mt-4" action="{{ route('submit.leave-request') }}" method="GET">
                <input type="hidden" name="schedule_id" id="scheduleId">
                <div class="mb-4">
                    <label for="date" class="block text-gray-700 text-sm font-bold mb-2">Date</label>
                    <input type="date" id="date" name="date"
                           class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                           required pattern="[0-9]{4}-W[0-9]{2}" min="{{ date('Y-m-d', strtotime('next Monday')) }}"
                           max="{{ date('Y-m-d', strtotime('next Monday +2 week -1 day')) }}">
                </div>
                <div class="mb-4">
                    <label for="reason" class="block text-gray-700 text-sm font-bold mb-2">Reason for leaving:</label>
                    <textarea id="reason" name="reason"
                              class="resize-none border rounded w-full h-32 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                              required></textarea>
                </div>
                <div class="flex items-center justify-end">
                    <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(scheduleId) {
            var modal = document.getElementById('myModal');
            var scheduleIdInput = document.getElementById('scheduleId');
            modal.classList.remove('hidden');

            scheduleIdInput.value = scheduleId;
        }

        function closeModal() {
            var modal = document.getElementById('myModal');
            modal.classList.add('hidden');
        }

        // Close modal when close button is clicked
        document.querySelector('.close').addEventListener('click', function () {
            closeModal();
        });
    </script>
</x-app-layout>
