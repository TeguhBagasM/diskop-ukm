@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Header Dashboard Style -->
            <div class="d-flex justify-content-center mb-4">
                <div class="dashboard-header">
                    <h3 class="mb-0">KALENDER KEGIATAN DINAS KOPERASI DAN UKM</h3>
                </div>
            </div>

            <div class="card">
                <div class="card-body" style="padding: 0;">
                    <!-- Header Kalender -->
                    <div class="d-flex justify-content-between align-items-center p-3" style="background-color: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0" style="font-weight: 600; color: #5a6c7d;">KALENDER</h5>
                        </div>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-outline-primary btn-sm me-2" onclick="changeMonth(-1)">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <span class="badge bg-primary me-2" style="border-radius: 15px; font-size: 14px; padding: 8px 16px;" id="currentMonth">
                                {{ $currentMonth }} {{ $currentYear }}
                            </span>
                            <button class="btn btn-outline-primary btn-sm me-3" onclick="changeMonth(1)">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                            <button class="btn btn-primary btn-sm" onclick="goToToday()">
                                Hari ini
                            </button>
                        </div>
                    </div>

                    <div class="p-4">
                        <!-- Calendar Grid -->
                        <div class="calendar-container">
                            <!-- Header Hari -->
                            <div class="calendar-header">
                                <div class="calendar-day-header">Sen</div>
                                <div class="calendar-day-header">Sel</div>
                                <div class="calendar-day-header">Rab</div>
                                <div class="calendar-day-header">Kam</div>
                                <div class="calendar-day-header">Jum</div>
                                <div class="calendar-day-header">Sab</div>
                                <div class="calendar-day-header">Min</div>
                            </div>

                            <!-- Calendar Body -->
                            <div class="calendar-body" id="calendarBody">
                                @php
                                    $currentDate = date('Y-m-d');
                                    $monthNumber = date('m', strtotime($currentMonth));
                                    $daysInMonth = date('t', strtotime($currentYear . '-' . $monthNumber . '-01'));
                                    $firstDayOfMonth = date('N', strtotime($currentYear . '-' . $monthNumber . '-01'));
                                @endphp

                                @for($week = 0; $week < 6; $week++)
                                    @for($day = 1; $day <= 7; $day++)
                                        @php
                                            $dayNumber = ($week * 7 + $day) - $firstDayOfMonth + 1;
                                            $isCurrentMonth = $dayNumber > 0 && $dayNumber <= $daysInMonth;
                                            $dateStr = $isCurrentMonth ? sprintf('%04d-%02d-%02d', $currentYear, $monthNumber, $dayNumber) : '';
                                            $isToday = $dateStr === $currentDate;
                                            $hasEvents = $isCurrentMonth && isset($agendaData[$dateStr]);
                                            $events = $hasEvents ? $agendaData[$dateStr] : [];
                                        @endphp

                                        <div class="calendar-cell {{ $isCurrentMonth ? 'current-month' : 'other-month' }} {{ $isToday ? 'today' : '' }}"
                                             @if($isCurrentMonth) data-date="{{ $dateStr }}" @endif>
                                            @if($isCurrentMonth)
                                                <div class="calendar-date">{{ $dayNumber }}</div>
                                                @if($hasEvents)
                                                    <div class="calendar-events">
                                                        @foreach($events as $event)
                                                            <div class="calendar-event {{ $event['type'] }}">
                                                                {{ $event['name'] }}
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            @else
                                                @if($dayNumber <= 0)
                                                    <div class="calendar-date">{{ date('t', strtotime($currentYear . '-' . ($monthNumber - 1) . '-01')) + $dayNumber }}</div>
                                                @else
                                                    <div class="calendar-date">{{ $dayNumber - $daysInMonth }}</div>
                                                @endif
                                            @endif
                                        </div>
                                    @endfor
                                @endfor
                            </div>
                        </div>

                        <!-- Legend -->
                        <div class="calendar-legend mt-4">
                            <h6 class="mb-3" style="color: #5a6c7d; font-weight: 600;">Keterangan:</h6>
                            <div class="d-flex flex-wrap gap-3">
                                <div class="d-flex align-items-center">
                                    <div class="legend-color holiday me-2"></div>
                                    <small>Hari Libur</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="legend-color national_holiday me-2"></div>
                                    <small>Hari Libur Nasional</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="legend-color agenda me-2"></div>
                                    <small>Agenda Kegiatan</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="legend-color today me-2"></div>
                                    <small>Hari Ini</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="row mt-4">
                <div class="col-md-3 mb-3">
                    <div class="card h-100" style="border-left: 4px solid #4caf50; box-shadow: 0 2px 8px rgba(0,0,0,.1);">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title text-success mb-1">Agenda Bulan Ini</h6>
                                    <h3 class="mb-0 text-success">{{ $monthlyAgenda ?? 8 }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-calendar-check fa-2x text-success opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card h-100" style="border-left: 4px solid #2196f3; box-shadow: 0 2px 8px rgba(0,0,0,.1);">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title text-primary mb-1">Hari Kerja</h6>
                                    <h3 class="mb-0 text-primary">{{ $workingDays ?? 22 }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-briefcase fa-2x text-primary opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card h-100" style="border-left: 4px solid #ff9800; box-shadow: 0 2px 8px rgba(0,0,0,.1);">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title text-warning mb-1">Hari Libur</h6>
                                    <h3 class="mb-0 text-warning">{{ $holidays ?? 8 }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-calendar-times fa-2x text-warning opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card h-100" style="border-left: 4px solid #f44336; box-shadow: 0 2px 8px rgba(0,0,0,.1);">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title text-danger mb-1">Libur Nasional</h6>
                                    <h3 class="mb-0 text-danger">{{ $nationalHolidays ?? 2 }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-flag fa-2x text-danger opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let currentYear = {{ $currentYear ?? date('Y') }};
let currentMonth = '{{ $currentMonth ?? date('F') }}';

function changeMonth(direction) {
    // This would typically make an AJAX call to load new month data
    // For now, just update the display
    const months = ['January', 'February', 'March', 'April', 'May', 'June',
                   'July', 'August', 'September', 'October', 'November', 'December'];

    let monthIndex = months.indexOf(currentMonth);
    monthIndex += direction;

    if (monthIndex < 0) {
        monthIndex = 11;
        currentYear--;
    } else if (monthIndex > 11) {
        monthIndex = 0;
        currentYear++;
    }

    currentMonth = months[monthIndex];
    document.getElementById('currentMonth').textContent = currentMonth + ' ' + currentYear;

    // Here you would typically reload the calendar data
    window.location.href = `{{ route('admin.calendar.calendar') }}?year=${currentYear}&month=${monthIndex + 1}`;
}

function goToToday() {
    window.location.href = `{{ route('admin.calendar.calendar') }}`;
}

// Add click event for calendar cells
document.querySelectorAll('.calendar-cell.current-month').forEach(cell => {
    cell.addEventListener('click', function() {
        const date = this.dataset.date;
        if (date) {
            // You can add functionality to show agenda details for this date
            console.log('Clicked date:', date);
        }
    });
});
</script>

<style>
.dashboard-header {
    background-color: #5a6c7d;
    color: white;
    padding: 15px 30px;
    border-radius: 50px;
    font-weight: bold;
    margin-top: 20px;
    font-size: 1.1rem;
    text-align: center;
    box-shadow: 0 2px 8px rgba(0,0,0,.1);
}

.card {
    border-radius: 12px;
    border: none;
    box-shadow: 0 2px 8px rgba(0,0,0,.1);
}

.calendar-container {
    background: white;
    border-radius: 8px;
    overflow: hidden;
}

.calendar-header {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
}

.calendar-day-header {
    padding: 12px;
    text-align: center;
    font-weight: 600;
    color: #5a6c7d;
    font-size: 0.9rem;
    border-right: 1px solid #dee2e6;
}

.calendar-day-header:last-child {
    border-right: none;
}

.calendar-body {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
}

.calendar-cell {
    min-height: 100px;
    padding: 8px;
    border-right: 1px solid #f1f1f1;
    border-bottom: 1px solid #f1f1f1;
    cursor: pointer;
    transition: background-color 0.2s ease;
    position: relative;
}

.calendar-cell:hover {
    background-color: #f8f9fa;
}

.calendar-cell:last-child {
    border-right: none;
}

.calendar-cell.other-month {
    background-color: #fafafa;
    color: #ccc;
}

.calendar-cell.today {
    background-color: #e3f2fd;
    border: 2px solid #2196f3;
}

.calendar-date {
    font-weight: 600;
    font-size: 14px;
    margin-bottom: 4px;
    color: #333;
}

.calendar-events {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.calendar-event {
    font-size: 10px;
    padding: 2px 4px;
    border-radius: 3px;
    color: white;
    font-weight: 500;
    line-height: 1.2;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.calendar-event.holiday {
    background-color: #ff5722;
}

.calendar-event.national_holiday {
    background-color: #f44336;
}

.calendar-event.agenda {
    background-color: #4caf50;
}

.calendar-legend {
    background-color: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
}

.legend-color {
    width: 16px;
    height: 16px;
    border-radius: 3px;
}

.legend-color.holiday {
    background-color: #ff5722;
}

.legend-color.national_holiday {
    background-color: #f44336;
}

.legend-color.agenda {
    background-color: #4caf50;
}

.legend-color.today {
    background-color: #2196f3;
}

@media (max-width: 768px) {
    .calendar-cell {
        min-height: 80px;
        padding: 4px;
    }

    .calendar-event {
        font-size: 8px;
        padding: 1px 2px;
    }

    .dashboard-header {
        font-size: 1rem;
        padding: 12px 20px;
    }
}
</style>
@endsection
