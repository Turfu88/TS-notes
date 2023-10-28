import Cookies from "js-cookie";

export default async function request(url, method = "POST", values = null, includeCookie = false) {
    let myHeaders = new Headers();

    // Pas de méthode PATCH dans ce projet
    myHeaders.append("Content-type", "application/json");    
    
    if(includeCookie === true){
        myHeaders.append("Authorization", 'Bearer ' + Cookies.get('token'));
    }
    let requestOptions = {
        method: method,
        headers: myHeaders,
    }
    if (values){
        const raw = JSON.stringify(values);
        requestOptions.body = raw;
    }

    let status, json;
    json = await fetch(url, requestOptions)
        .then(response => {
            status = response.status;
            return response.text();
        })
        .then(result => {
            if(result) return JSON.parse(result);
            return;
        })
        .catch(result => console.error(result));

    return {status, json};
}
