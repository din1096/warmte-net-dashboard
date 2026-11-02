<x-layout>
    <h2 class="text-xl font-semibold text-gray-900">Upload CSV File to Warmtenet Database</h2>

    @if(session('success'))
        <p class="mt-4 text-green-700">{{ session('success') }}</p>
    @endif
    @if(session('error'))
        <p class="mt-4 text-red-700">{{ session('error') }}</p>
    @endif

    <form class="mt-6" action="{{ route('csv.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="csv_file" class="block text-sm font-medium text-gray-700">Choose CSV File:</label>
        <input class="mt-2" type="file" name="csv_file" id="csv_file" accept=".csv" required>
        <br><br>
        <button type="submit" class="rounded-md bg-gray-800 px-3 py-2 text-sm font-medium text-white hover:bg-gray-700">
            Upload and Import
        </button>
    </form>
</x-layout>
