function getReservationsByDay(day) {
    const result = [];
    reservations.forEach((reservation) => {
        if (reservation.date.getDate() === day.getDate())
            result.push(reservation);
    });
    return result;
}

function AfficherTableau(reservations){
    reservations.forEach((reservation) => {
        let tableRowParent = document.querySelector('.table-row');
    });
}

const daysTag = document.querySelector(".days"),
    currentDate = document.querySelector(".current-date"),
    prevNextIcon = document.querySelectorAll(".icons span");

// getting new date, current year and month
let date = new Date(),
    currYear = date.getFullYear(),
    currMonth = date.getMonth();

// storing full name of all months in array
const months = ["January", "February", "March", "April", "May", "June", "July",
    "August", "September", "October", "November", "December"];

const renderCalendar = () => {
    let firstDayofMonth = new Date(currYear, currMonth, 1).getDay(), // getting first day of month
        lastDateofMonth = new Date(currYear, currMonth + 1, 0).getDate(), // getting last date of month
        lastDayofMonth = new Date(currYear, currMonth, lastDateofMonth).getDay(), // getting last day of month
        lastDateofLastMonth = new Date(currYear, currMonth, 0).getDate(); // getting last date of previous month
    let liTag = "";

    for (let i = firstDayofMonth; i > 0; i--) { // creating li of previous month last days
        liTag += `<li class="inactive">${lastDateofLastMonth - i + 1}</li>`;
    }

    for (let i = 1; i <= lastDateofMonth; i++) { // creating li of all days of current month
        // adding active class to li if the current day, month, and year matched
        let isToday = i === date.getDate() && currMonth === new Date().getMonth()
        && currYear === new Date().getFullYear() ? "active" : "normal";
        liTag += `<li class="${isToday}" id="${isToday}">${i}</li>`;
    }

    for (let i = lastDayofMonth; i < 6; i++) { // creating li of next month first days
        liTag += `<li class="inactive">${i - lastDayofMonth + 1}</li>`
    }
    currentDate.innerText = `${months[currMonth]} ${currYear}`; // passing current mon and yr as currentDate text
    daysTag.innerHTML = liTag;
}
renderCalendar();

prevNextIcon.forEach(icon => { // getting prev and next icons
    icon.addEventListener("click", () => { // adding click event on both icons
        // if clicked icon is previous icon then decrement current month by 1 else increment it by 1
        currMonth = icon.id === "prev" ? currMonth - 1 : currMonth + 1;

        if(currMonth < 0 || currMonth > 11) { // if current month is less than 0 or greater than 11
            // creating a new date of current year & month and pass it as date value
            date = new Date(currYear, currMonth, new Date().getDate());
            currYear = date.getFullYear(); // updating current year with new date year
            currMonth = date.getMonth(); // updating current month with new date month
        } else {
            date = new Date(); // pass the current date as date value
        }
        renderCalendar(); // calling renderCalendar function
    });
});
const arrows=document.querySelectorAll(".arrow-class")
let getDate=document.querySelectorAll('.normal');
let getActiveDate;
let getMonth=document.querySelector(".current-date");
let dateField=document.querySelector("#date");
let setDateElement=document.querySelector("#date-field");
let my_date;
function fetch_date(){
    getDate=document.querySelectorAll('.normal');
    getActiveDate=document.querySelector('#active');
    getMonth=document.querySelector(".current-date");
    dateField=document.querySelector("#date");
    setDateElement=document.querySelector("#date-field");
    getDate.forEach((oneDate)=>{
        oneDate.addEventListener("click",()=> {
                my_date= oneDate.textContent + ' ' + getMonth.textContent;
                dateField.textContent=my_date;
                let reservationsByDay=getReservationsByDay(new Date(my_date));
                reservationsByDay.forEach((reservationByDay)=>{
                    console.log(reservationByDay.startTime+" to "+reservationByDay.endTime);
                })
                AfficherTableau(reservationsByDay);
                setDateElement.innerHTML="<h1>"+my_date+"</h1>";
                window.location.href = ("#find-time");
            }
        );
    })
    getActiveDate.addEventListener("click",()=>{
        my_date= getActiveDate.textContent + ' ' + getMonth.textContent;
        dateField.textContent=my_date;
        setDateElement.innerHTML="<h1>"+my_date+"</h1>";
        window.location.href = ("#find-time");
    });
}
fetch_date();
arrows.forEach((arrow)=>{
    arrow.addEventListener("click",()=>{
        fetch_date();
    })
})




