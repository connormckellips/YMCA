const calendarGrid = document.getElementById("calendarGrid");
const calendarTitle = document.getElementById("calendarTitle");
const prevMonthButton = document.getElementById("prevMonth");
const nextMonthButton = document.getElementById("nextMonth");

let currentDate = new Date(2024, 10); // Start in November 2024

// Class schedules for each month
const classSchedules = {
    "2024-10": [1, 5, 8, 15, 20, 23, 29],  // November 2024
    "2024-11": [3, 10, 14, 19, 22, 26, 30], // December 2024
    "2025-0": [5, 10, 15, 20, 25, 28],      // January 2025
};

function updateCalendar() {
    const month = currentDate.getMonth();
    const year = currentDate.getFullYear();
    const monthKey = `${year}-${month}`; // Format key to match classSchedules keys

    // Set calendar title
    const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    calendarTitle.textContent = `Class Schedule for ${monthNames[month]} ${year}`;
    calendarGrid.innerHTML = "";

    // Clear previous days
    calendarGrid.querySelectorAll(".day, .empty").forEach(day => day.remove());

    // Get the first day of the month and total days in month
    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();

    // Get class dates for the current month
    const classDates = classSchedules[monthKey] || [];

    // Add empty placeholders for days before the 1st of the month
    for (let i = 0; i < firstDay; i++) {
        const emptyDiv = document.createElement("div");
        emptyDiv.classList.add("empty");
        calendarGrid.appendChild(emptyDiv);
    }

    // Generate each day of the month
    for (let day = 1; day <= daysInMonth; day++) {
       // const dateKey = `${year}-${String(month).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
        const dayDiv = document.createElement("div");
        dayDiv.classList.add("day");
        dayDiv.textContent = day;

        // Make days clickable if a class is scheduled
        if (classDates.includes(day)) {
            dayDiv.classList.add("clickable");
            dayDiv.addEventListener("click", () => redirectToDayDetails(year, month, day));
            dayDiv.addEventListener("mouseover", () => showTooltip(dayDiv, day))
            dayDiv.addEventListener("mouseout", hideTooltip);
        } else {
            dayDiv.classList.add("unclickable");
        }

        calendarGrid.appendChild(dayDiv);
    }
}

function showTooltip(dayDiv, day) {
    const tooltip = document.createElement("div");
    tooltip.classList.add("tooltip");

    const classDiv = document.createElement("div");
    classDiv.innerHTML = `<strong>${day}</strong>`;
    tooltip.appendChild(classDiv);

    dayDiv.appendChild(tooltip);
}

function hideTooltip() {
    const tooltip = event.currentTarget.querySelector(".tooltip");
    if (tooltip) {
        tooltip.remove();
    }
}

// Move to the previous month
prevMonthButton.addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    updateCalendar();
});

// Move to the next month
nextMonthButton.addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    updateCalendar();
});

// Select a day and show an alert
function selectDay(dayElement) {
    document.querySelectorAll('.day').forEach(day => day.classList.remove('selected'));
    dayElement.classList.add('selected');
    alert(`Class scheduled on ${dayElement.textContent}!`);
}

function redirectToDayDetails(year, month, day) {
    window.location.href = `day-details.html?date=${year}${month}${day}`;
}

updateCalendar();