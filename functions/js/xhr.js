function quickXHR(url, method, data, result) {
    const xhr = new XMLHttpRequest();
    xhr.open(method, url, true);
    xhr.onload = () => {
        console.log(xhr.responseText);
        if (xhr.status === 200) {
            if (xhr.responseText === 'success') {
                notification(result);
            } else {
                notification("Błąd: " + xhr.responseText);
            }
        }
    };

    xhr.send(data);
}