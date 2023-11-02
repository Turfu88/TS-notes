export function createEvents(timesheets, bankHolidays) {
    const completed = "#B2FFD6";
    const uncompleted = "#F8A7A5";
    const holiday = "#72fcf6"
    let out = [];
    let id = 1;
    Object.entries(bankHolidays).forEach((bankHoliday) => {
        out.push({
            id,
            start: bankHoliday[0],
            end: bankHoliday[0],
            title: "🏖",
            editable: true,
            backgroundColor: holiday,
            textColor: "black",
            type: "TS"
        })
        id++;
        out.push({
            id,
            start: bankHoliday[0],
            end: bankHoliday[0],
            title: "Férié",
            editable: true,
            backgroundColor: holiday,
            textColor: "black",
            type: "Podio"
        })
        id++;
    });
    timesheets.forEach((timesheet) => {
        const eventsFound = out.filter((event) => event.start === timesheet.date);
        if (0 === eventsFound.length) {
            // On créé les 2 events (1 pour le compte des timesheet de la journée et 1 pour Podio à jour)
            out.push({
                id,
                start: timesheet.date,
                end: timesheet.date,
                title: timesheet.worktime === 7 && timesheet.is_working === "0" ? "🏖" : timesheet.worktime,
                editable: true,
                backgroundColor: timesheet.worktime === 7 ? timesheet.is_working === "0" ? holiday : completed : uncompleted,
                textColor: "black",
                type: "TS"
            })
            id++;
            const podioUpdatedTime = timesheet.is_podio_updated ? timesheet.worktime : 0;
            out.push({
                id,
                start: timesheet.date,
                end: timesheet.date,
                title: podioUpdatedTime === 7 && timesheet.is_working === "0" ? "😎" : podioUpdatedTime,
                editable: true,
                backgroundColor: podioUpdatedTime === 7 ? timesheet.is_working === "0" ? holiday : completed : uncompleted,
                textColor: "black",
                type: "Podio"
            })
            id++;
        } else {
            out = out.map((event) => {
                if (event.start === timesheet.date) {
                    if (event.type === 'TS') {
                        const newTitle = timesheet.worktime + event.title;
                        return {
                            ...event,
                            title: newTitle,
                            backgroundColor: newTitle === 7 ? completed : uncompleted,
                        }
                    }
                    const newTitle = timesheet.is_podio_updated ? timesheet.worktime + event.title : event.title;
                    return {
                        ...event,
                        title: newTitle,
                        backgroundColor: newTitle === 7 ? completed : uncompleted,
                    }
                }
                return event;
            });

        }
    });

    return out.map((event) => {
        return { ...event, title: event.title.toString() }
    });
}

export function getBankHolidays() {
    var myHeaders = new Headers();
    myHeaders.append("Accept", "application/json");

    var requestOptions = {
        method: 'GET',
        headers: myHeaders,
        redirect: 'follow'
    };

    return fetch("https://calendrier.api.gouv.fr/jours-feries/metropole.json", requestOptions)
        .then(response => response.text())
        .then(result => JSON.parse(result))
        .catch(error => console.log('error', error));
}