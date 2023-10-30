export function createEvents(timesheets) {
    console.log(timesheets);
    const completed = "#B2FFD6";
    const uncompleted = "#F8A7A5";
    let out = [];
    let id = 1;
    timesheets.forEach((timesheet) => {
        const eventsFound = out.filter((event) => event.start === timesheet.date);
        if (0 === eventsFound.length) {
            // On créé les 2 events (1 pour le compte des timesheet de la journée et 1 pour Podio à jour)
            out.push({
                id, 
                start: timesheet.date,
                end: timesheet.date,
                title: timesheet.worktime,
                editable: true,
                backgroundColor: timesheet.worktime === 7 ? completed : uncompleted,
                textColor: "black",
                type: "TS"
            })
            id++;
            const podioUpdatedTime = timesheet.is_podio_updated ? timesheet.worktime : 0;
            out.push({
                id, 
                start: timesheet.date,
                end: timesheet.date,
                title: podioUpdatedTime,
                editable: true,
                backgroundColor: podioUpdatedTime === 7 ? completed : uncompleted,
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
    console.log(out);
    
    return out.map((event) => {
        return {...event, title: event.title.toString()}
    });    
}
