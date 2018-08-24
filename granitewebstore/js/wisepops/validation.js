Validation.add('validate-wisepops-id', 'Please enter your wisepops user id before activating wisepops.', function(v) {
    var statusElt = $('wisepopsconnect_settings_status');
    var statusEltValue = statusElt.getValue();

    if (statusEltValue == 1) {
        if (Validation.get('IsEmpty').test(v)) {
            return false;
        }
    }

    return true;
})