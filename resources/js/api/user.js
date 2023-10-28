import request from "./request";
import Cookies from 'js-cookie';

export async function login(params) {
    return await request('/api/login', "POST", params).then((res) => {
        console.log(res);
        if (res.status === 200) {
            Cookies.set('token', res.json.authorisation.token);
            return true;
        }
        return false;
    });
}

export function logout() {
    Cookies.remove('token');
    return null;
}

export async function createUser(params) {
    return await request('/api/register', "POST", params).then((res) => {
        if (res.status === 201) {
            Cookies.set('token', res.json.authorisation.token);
            return true;
        }
        return false;
    })
}

export async function getUser() {
    return await request(`/api/user`, "GET", null, true).then((res) => {
        console.log(res);
        if (res.status === 200) {
            return res.json;
        }
        return null;
    });
}


export async function updateUser(params) {
    return await request('/api/user/update', "PUT", params, true).then((res) => {
        return res;
    })
}
