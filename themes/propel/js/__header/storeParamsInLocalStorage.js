function getQueryParams() {
    var queryParams = {};
    var queryString = window.location.search.substring(1);
    var vars = queryString.split('&');
    for (var i = 0; i < vars.length; i++) {
        var pair = vars[i].split('=');
        queryParams[decodeURIComponent(pair[0])] = decodeURIComponent(pair[1] || '');
    }
    return queryParams;
}

function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}

function saveUtmParams() {
    var params = getQueryParams();
    var utmParams = {
        utm_source: 'LT_UTM_Source__c',
        utm_medium: 'LT_UTM_Medium__c',
        utm_campaign: 'LT_UTM_Campaign__c'
    };
    Object.keys(utmParams).forEach(key => {
        if (params[key]) {
            localStorage.setItem(utmParams[key], params[key]);
            setCookie(utmParams[key], params[key], 7); // Saving as cookies for 7 days
        }
    });
}

function appendUtmParamsToFormInputs(form) {
    var utmParams = {
        utm_source: 'LT_UTM_Source__c',
        utm_medium: 'LT_UTM_Medium__c',
        utm_campaign: 'LT_UTM_Campaign__c'
    };
    Object.keys(utmParams).forEach(key => {
        var fieldName = utmParams[key];
        var value = localStorage.getItem(fieldName) || getCookie(fieldName);
        if (value && form.elements[fieldName]) {
            form.elements[fieldName].value = value;
        }
    });
}

function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

const storeParamsInLocalStorage = () => {
    document.addEventListener('DOMContentLoaded', function() {
        saveUtmParams();
        var intervalId = {};
        setTimeout(() => {
            intervalId['#mktoForm_1001'] = setInterval(() => checkAndFillForm('#mktoForm_1001'), 3000);
            intervalId['#mktoForm_1336'] = setInterval(() => checkAndFillForm('#mktoForm_1336'), 3000);
        }, 2000);
        
        function checkAndFillForm(formId) {
            var form = document.querySelector(formId);
            if (!form) return; 
            appendUtmParamsToFormInputs(form);
            var source = form.querySelector(`[name="LT_UTM_Source__c"]`);
            var medium = form.querySelector(`[name="LT_UTM_Medium__c"]`);
            var campaign = form.querySelector(`[name="LT_UTM_Campaign__c"]`);
            if (!source || !medium || !campaign) {
                clearInterval(intervalId[formId]);
                return;
            }
            if (source.value.trim() !== '' || medium.value.trim() !== '' || campaign.value.trim() !== '') {
                clearInterval(intervalId[formId]);
            }
        }
    });
};

export default storeParamsInLocalStorage;