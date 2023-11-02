import moment from "moment";

export function prepareValuesForRequest(values, date) {
    if (true === values.is_working) {
        return {
            date: moment(date).format("YYYY-MM-D"),
            is_podio_updated: values.is_podio_updated,
            is_working: values.is_working,
            note: values.note === "" ? null : values.note,
            project: values.project,
            ticket: values.ticket,
            worktime: values.worktime
        }
    }
    return {
        date: moment(date).format("YYYY-MM-D"),
        is_podio_updated: true,
        is_working: values.is_working,
        note: values.note,
        project: null,
        ticket: 0,
        worktime: values.worktimeOff
    }
}

export function getTimesheetsConsumption(timesheets) {
    if (undefined === timesheets) {
        return { totalWorktime: 0, totalWorktimeUpdatedOnPodio: 0 };
    }
    const totalWorktime = timesheets.reduce((currentTotal, item) => {
        return parseInt(item.worktime) + currentTotal;
    }, 0);
    const totalWorktimeUpdatedOnPodio = timesheets.reduce((currentTotal, item) => {
        return item.is_podio_updated ? parseInt(item.worktime) + currentTotal : currentTotal;
    }, 0);

    return { totalWorktime, totalWorktimeUpdatedOnPodio };
}

export function filterTimesheetsFromSelectedMonth(timesheets, month) {
    return timesheets.filter((timesheet) => moment(timesheet.date).month() + 1 === month);
}

export function getActiveDays(bankHolidays, monthSelected) {
    const bankHolidaysFormated = Object.keys(bankHolidays);
    const momentDate = moment(monthSelected);
    const daysThisMonth = momentDate.daysInMonth();
    let jourEnCours = momentDate.startOf('month');;
    let count = 1;
    let workDays = [];
    while (count <= daysThisMonth) {
        // Vérifiez si le jour en cours est un jour de la semaine (lundi à vendredi)
        if (jourEnCours.day() >= 1 && jourEnCours.day() <= 5) {
            workDays.push(jourEnCours.format("YYYY-MM-DD"));
        }
        jourEnCours.add(1, 'day');
        count++;
    }

    return workDays.filter((day) => !bankHolidaysFormated.includes(day)).length;
}

export function getDaysUpdated(timesheets) {
    const totalHours = timesheets.reduce((currentTotal, item) => {
        return item.worktime + currentTotal
    }, 0);

    return totalHours / 7;
}

export function getProjectsWorkedOn(timesheets) {
    let projects = [];
    timesheets.forEach((timesheet) => {
        if (!projects.includes(timesheet.project)) {
            projects.push(timesheet.project);
        }
    });

    return projects;
}

export function getTotalHoursPerTicket(timesheets) {
    let totalHoursPerTicket = [];
    timesheets.forEach((timesheet) => {
        const ticketFound = totalHoursPerTicket.find((ticket) => ticket.ticket === timesheet.ticket && ticket.project === timesheet.project);
        if (undefined === ticketFound) {
            totalHoursPerTicket.push({
                ticket: timesheet.ticket,
                project: timesheet.project,
                worktime: timesheet.worktime
            });
        } else {
            totalHoursPerTicket = totalHoursPerTicket.map((ticket) => {
                if (ticket.ticket === timesheet.ticket && ticket.project === timesheet.project) {
                    return {...ticket, worktime: ticket.worktime + timesheet.worktime};
                }
                return ticket;
            })
        }
    });

    return totalHoursPerTicket;
}

export function getTotalWorkedByProject(project, timesheets) {
    const totalHourWorked =  timesheets.reduce((currentTotal, timesheet) => {
        if (timesheet.project === project) {
            return timesheet.worktime + currentTotal;
        }
        return currentTotal;
    }, 0);

    return formatDays(totalHourWorked / 7);
}

export function formatDays(daysWorked) {
    if (daysWorked * 7 % 7 === 0) {
        return `${(daysWorked).toString()} jour${daysWorked >= 2 ? 's' : ''}`;
    }

    return `${(Math.ceil((daysWorked) * 10) / 10).toFixed(1)} jour${daysWorked >= 2 ? 's' : ''}`;
}
