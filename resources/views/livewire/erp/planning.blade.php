<div class="card">
    <div class="card-header">
        <div class="card-title">Planning de la semaine </div>
        <div class="card-actions">
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <td class="text-center">{{ ucfirst($carbon->dayName) }} {{ $carbon->startOfWeek()->format('d-m') }}</td>
                <td class="text-center">{{ ucfirst($carbon->addDays(1)->dayName) }} {{ $carbon->startOfWeek()->format('d-m') }}</td>
                <td class="text-center">{{ ucfirst($carbon->addDays(2)->dayName) }} {{ $carbon->startOfWeek()->format('d-m') }}</td>
                <td class="text-center">{{ ucfirst($carbon->addDays(3)->dayName) }} {{ $carbon->startOfWeek()->format('d-m') }}</td>
                <td class="text-center">{{ ucfirst($carbon->addDays(4)->dayName) }} {{ $carbon->startOfWeek()->format('d-m') }}</td>
                <td class="text-center">{{ ucfirst($carbon->addDays(5)->dayName) }} {{ $carbon->startOfWeek()->format('d-m') }}</td>
                <td class="text-center">{{ ucfirst($carbon->addDays(6)->dayName) }} {{ $carbon->startOfWeek()->format('d-m') }}</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $carbon->startOfWeek()->format('d-m') }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>
