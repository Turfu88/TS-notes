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
    const totalWorktime = timesheets.reduce((currentTotal, item) => {
        return item.worktime + currentTotal
    }, 0);
    const totalWorktimeUpdatedOnPodio = timesheets.reduce((currentTotal, item) => {
        return item.is_podio_updated ? item.worktime + currentTotal : currentTotal
    }, 0);
    
    return {totalWorktime, totalWorktimeUpdatedOnPodio};
}
