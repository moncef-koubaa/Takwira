const dayContainers = document.querySelectorAll('.day');
const nextWeekButton = document.querySelector('.right');
const prevWeekButton = document.querySelector('.left');
const todayButton = document.querySelector('.today-btn');

const today = new Date();
today.setHours(0);
today.setMinutes(0);
today.setSeconds(0);

const thisWeek = {
    weekStart: nextDay(today, -today.getDay() + 1),
    weekEnd: nextDay(today, 7 - today.getDay())
}

let currentWeek = thisWeek;

function nextDay(day, n = 1) {
    const oneDay = 24 * 60 * 60 * 1000;
    return new Date(day.getTime() + (n * oneDay));
}

function nextWeek(week) {
    const currentWeekStart = week.weekStart;
    const currentWeekEnd = week.weekEnd;

    const nextWeekStartDate = nextDay(currentWeekStart, 7);

    const nextWeekEndDate = nextDay(currentWeekEnd, 7);

    return {
        weekStart: nextWeekStartDate,
        weekEnd: nextWeekEndDate
    };
}

function prevWeek(week) {
    const currentWeekStart = week.weekStart;
    const currentWeekEnd = week.weekEnd;

    const prevWeekStartDate = nextDay(currentWeekStart, -7);

    const prevWeekEndDate = nextDay(currentWeekEnd, -7);

    return {
        weekStart: prevWeekStartDate,
        weekEnd: prevWeekEndDate
    };
}

function getReservationsByDay(day) {
    const result = [];
    reservations.forEach((reservation) => {
        if (reservation.date.getDate() === day.getDate())
            result.push(reservation);
    });
    return result;
}

function formatDate(date) {
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    const daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

    const monthAbbr = months[date.getMonth()];
    const day = date.getDate();
    const dayOfWeekAbbr = daysOfWeek[date.getDay()];

    return `${monthAbbr} ${day} - ${dayOfWeekAbbr}`;
}

function makeHeader(day) {
    const header = document.createElement('h4');
    header.classList.add('rounded', 'text-center', 'week-day');
    if (day.toDateString() === today.toDateString()) {
        header.classList.add('today');
    }
    header.innerText = formatDate(day);
    return header;
}

function makeReservation(reservation) {
    const reservationDiv = document.createElement('div');
    reservationDiv.classList.add('reservation', 'rounded');
    reservationDiv.innerHTML = `<h4 class="text-center rounded">${reservation.startTime} - ${reservation.endTime}</h4>                  
                    <h5 class="text-center">${reservation.client.name}</h5>   
                    <h5>Number: <span class="">${reservation.client.phoneNumber}</span></h5>                   
                    <h5>Email:</h5>
                    <p class="text-center">${reservation.client.email}</p>`;
    return reservationDiv;
}

function renderDay(day, dayIndex) {
    const dayReservations = getReservationsByDay(day);
    dayContainers[dayIndex].innerHTML = '';
    dayContainers[dayIndex].appendChild(makeHeader(day));
    dayReservations.forEach((reservation) => {
        dayContainers[dayIndex].appendChild(makeReservation(reservation));
    });
}

function renderWeek(week) {
    let currentDay = week.weekStart;
    let dayIndex = 0;
    while (currentDay.getTime() <= week.weekEnd.getTime()) {
        renderDay(currentDay, dayIndex);
        currentDay = nextDay(currentDay);
        dayIndex++;
    }
}

nextWeekButton.addEventListener('click', () => {
    currentWeek = nextWeek(currentWeek);
    renderWeek(currentWeek);
});

prevWeekButton.addEventListener('click', () => {
    currentWeek = prevWeek(currentWeek);
    renderWeek(currentWeek);
});

todayButton.addEventListener('click', () => {
    currentWeek = thisWeek;
    renderWeek(currentWeek);
});

renderWeek(thisWeek);
