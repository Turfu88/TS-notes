import request from "./request";
import Cookies from 'js-cookie';
import jwt_decode from "jwt-decode";
import { getProjects } from "./project";

export async function login(params) {
    return await request('/api/login', "POST", params).then((res) => {
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

export async function getUserInfo() {
    return await request(`/api/user/info`, "GET", null, true).then((res) => {
        if (res.status === 200) {
            return res.json;
        }
        return null;
    });
}

export async function getUser() {
    return await request(`/api/user`, "GET", null, true).then((res) => {
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

export function isLogedIn() {
    let cookie = Cookies.get('token');
    let token = null;
    if (cookie) {
        token = jwt_decode(cookie);
    }
    if (token) {
        return token.sub ? true : false;
    }

    return false;
}

export function getUserProjects(user) {
    const allProjects = getProjects();
    return JSON.parse(user.projects).map((id) => {
        return allProjects.find((project) => project.id === id);
    });
}
