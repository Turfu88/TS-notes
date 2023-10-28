import request from "./request";

export async function createTimesheet(params) {
    return await request('/api/timesheet', "POST", params, true).then((res) => {
        console.log(res);
        if (res.status === 200) {
            return res.json;
        }
        return null;
    });
}

export async function updateTimesheet(id, params) {
    return await request(`/api/timesheet/${id}`, "PUT", params, true).then((res) => {
        console.log(res);
        if (res.status === 200) {
            return res.json;
        }
        if (res.status === 201) {
            return res.json;
        }
        return null;
    });
}

export async function removeTimesheet(id) {
    return await request(`/api/timesheet/${id}`, "DELETE", null, true).then((res) => {
        console.log(res);
        if (res.status === 200) {
            return res.json.content;
        }
        return null;
    });
}
