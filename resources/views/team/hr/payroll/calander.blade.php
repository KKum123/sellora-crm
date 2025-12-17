<link rel="stylesheet" href="{{ url('/') }}/calendar-gc.css">
<style>
.table-responsive table{
  min-width : 0!important;
}
.gc-calendar table.calendar td {
  height: 75px!important;
}
</style>
<div class="col-lg-12">
          <div class="card">
            <!-- <div class="card-header">
              <h4 class="card-title">View All Lead</h4>
            </div> -->

            
            <div class="card-body"> 
              <div class="row">
                <div class="col-xl-8">
                  <div class="table-responsive">
                  <div id="calendar"></div>      
                  </div>                  
                  <!-- responsive table end --> 
                </div>

                <div class="col-xl-4">
                     <div class="employedetails-short p-lg-3">
                         <h3 class="text-center">
                          <i class="ri-calendar-2-fill" style="vertical-align: bottom;"></i> {{ date('M', mktime(0, 0, 0, $month, 1)) }} {{ $year }}</h3>
                         <ul class="m-0 p-0">
                            <li class="d-lg-flex align-items-start justify-content-between"><span>Employee Name:</span> <div>{{ !empty($singleData) ? $singleData->name : '' }}</div></li>
                            <li class="d-lg-flex align-items-start justify-content-between"><span>Employee ID:</span> <div>#{{ !empty($singleData) ? $singleData->employeeIdCode : '' }}</div></li>
                            <li class="d-lg-flex align-items-start justify-content-between"><span>Total Leave:</span> <div>{{ $totalLeave }}</div></li>
                         </ul>                        
                       
                     </div>
                </div>



              </div>
            </div>
          </div>
        </div>


<script src="{{ url('/') }}/calendar-gc.min.js"></script>


<script>
  $(function () {
   
    var month = <?= json_encode((int) $month) ?> - 2 // Convert PHP month to zero-based JavaScript month
    var year = <?= json_encode((int) $year) ?>; // Convert PHP year to number

    console.log("Initializing calendar with:", month, year); // Debugging output

    // Set the picked date to the custom month and year
    gcObject.pickedDate = new Date(year, month, 1);
    
    // Initialize the calendar
    var calendar = $("#calendar").calendarGC({
        dayBegin: 0,
        prevIcon: '&#x3c;',
        nextIcon: '&#x3e;',
        onPrevMonth: function (e) {
            console.log("Prev month:", e);
        },
        onNextMonth: function (e) {
            console.log("Next month:", e);
        },
        events: getHoliday(month + 2, year),
        onclickDate: function (e, data) {
            console.log("Clicked date:", data);
        }
    });

    // Re-render the calendar with the selected date
    gcObject.render();
});

// Function to generate holiday events
function getHoliday(selectedMonth, selectedYear) {
    var totalDays = new Date(selectedYear, selectedMonth, 0).getDate();
    var events = [];
    var customHolidays = [];

    // List of custom holidays (Format: MM-DD)
    @if(!empty($customHolidaysJson))
         customHolidays = <?= $customHolidaysJson; ?>;
    @endif

    
    for (var i = 1; i <= totalDays; i++) {
        var newDate = new Date(selectedYear, selectedMonth - 1, i);
        var dateKey = (selectedMonth) + "-" + i; // Create key as "MM-DD"

        // Add Sundays as "Leave"
        if (newDate.getDay() === 0) {  
            events.push({
                date: newDate,
                eventName: "", // event name
                // className: "badge bg-danger",
                dateColor: "red"
            });
        }

        // // Add Saturdays as "Half-day"
        if (newDate.getDay() === 6) {  
            events.push({
                date: newDate,
                eventName: "",// event name
                // className: "badge bg-danger",
                dateColor: "red"
            });
        }

        // Check if date is in the customHolidays list
        @if(!empty($customHolidaysJson))
        if (customHolidays[dateKey]) {
            events.push({
                date: newDate,
                eventName: customHolidays[dateKey].name,
                className: "badge " + customHolidays[dateKey].class,
                dateColor: customHolidays[dateKey].color
            });
        }
        @endif
    }

    return events;
}
</script>