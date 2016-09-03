"use strict";
(function(window) {
    function encodeURIComponents(obj) { // for post and get request encoding
        var keys = Object.keys(obj);
        var data = '';
        keys.forEach(function(key) {data += key + '=' + encodeURIComponent(obj[key]) + "&"});
        return data.slice(0, data.length - 1);
    }
    function resolve(data) { // if request returned success
        console.info("\nresolve=",JSON.parse(data),'\n');
        if (data.length > 0) return JSON.parse(data); // parse data from server
        return Promise.reject({data: {error_message: 'no response'} }); // if response is '' then treat it as error
    }
    function reject(error) { // if request rejected
        console.error('error=', error);
        return Promise.reject(error.data && error.data.error_message || 'Service unavailable, check your internet connection.')
    }

    window.sendRequest = function(method, url, dataOrParams) { //dataOrParams format: {name: "Ivan", age: 21}
        // show request info
        console.info('new request has been created'.toUpperCase());
        console.log('----------------------------');
        console.log('url: ', url);
        console.log('method: ', method);
        console.log('dataToSend: ',dataOrParams);
        console.log('----------------------------');

        return new Promise(function(resolve, reject) {
            var xhr = new XMLHttpRequest(); // if method is GET and you send some data as params, lets encode it
            if(method == "GET" && dataOrParams) url += '?' + encodeURIComponents(dataOrParams);
            xhr.open(method, url, true);
            xhr.withCredentials = true; // always write your cookie
            if(method == "GET" && dataOrParams) { //if some params for GET were given, encode it and send
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.send();
            } else if (method == "POST" && dataOrParams) { // if some data for POST request were given
                var formData = new FormData(),
                    keys = Object.keys(dataOrParams);
                keys.forEach(function(elem) {
                    formData.append(elem, dataOrParams[elem]); // create formData object and fill it in;
                });
                xhr.send(formData);
            } else xhr.send(); // if any other method or no params ig given, just send request
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4) { // response check;
                    if (xhr.status != 200) reject(xhr.responseText); // this way goes in catch
                    else resolve(xhr.responseText); // this way goes in then
                }
            };
        }).then(resolve).catch(reject);
    }
})(window);

sendRequest('POST', 'http://anywhere', {name: "Ivan", age: 21})
    .then(function(data) {
        //SUCCESS
    }, function(error) {
        // ERROR
    }, function() {
        //FINALLY
    }).then(function(data) {
        //SUCCESS
    }, null, function() { // ERROR  you can scip any hendler by putting null on its place
        //FINALLY
    }).catch(function(error) {
        // any error will come here
    });

// promises chain could be endless/**