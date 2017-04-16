function hideLecture(chosen) {
    chosen = parseInt(chosen);
    if ((chosen % 3) == 0) {
        $("#r" + (chosen + 1)).addClass('hidden');
        $('#r' + (chosen + 1)).attr('disabled', true);
        $("#r" + (chosen + 2)).addClass('hidden');
        $('#r' + (chosen + 2)).attr('disabled', true);
        
    } else if ((chosen % 3) == 1) {
        $("#r" + (chosen - 1)).addClass('hidden');
        $('#r' + (chosen - 1)).attr('disabled', true);
        $("#r" + (chosen + 1)).addClass('hidden');
        $('#r' + (chosen + 1)).attr('disabled', true);
    } else if ((chosen % 3) == 2) {
        $("#r" + (chosen - 1)).addClass('hidden');
        $('#r' + (chosen - 1)).attr('disabled', true);
        $("#r" + (chosen - 2)).addClass('hidden');
        $('#r' + (chosen - 2)).attr('disabled', true);
    }
    for (i = 1; i <= 14; i++) { 
        if (i != chosen && (i % 3 == chosen % 3)) {
            $("#r" + i).addClass('hidden');
            $('#r' + i).attr('disabled', true);
        }
    }
}

function hidePoster(chosen) {
    chosen = parseInt(chosen);
    if ((chosen % 3) == 0) {
        $("#p" + (chosen + 1)).addClass('hidden');
        $('#p' + (chosen + 1)).attr('disabled', true);
        $("#p" + (chosen + 2)).addClass('hidden');
        $('#p' + (chosen + 2)).attr('disabled', true);
    } else if ((chosen % 3) == 1) {
        $("#p" + (chosen - 1)).addClass('hidden');
        $('#p' + (chosen - 1)).attr('disabled', true);
        $("#p" + (chosen + 1)).addClass('hidden');
        $('#p' + (chosen + 1)).attr('disabled', true);
    } else if ((chosen % 3) == 2) {
        $("#p" + (chosen - 1)).addClass('hidden');
        $('#p' + (chosen - 1)).attr('disabled', true);
        $("#p" + (chosen - 2)).addClass('hidden');
        $('#p' + (chosen - 2)).attr('disabled', true);
    }
    for (i = 1; i <= 5; i++) { 
        if (i != chosen && (i % 3 == chosen % 3)) {
            $("#p" + i).addClass('hidden');            
            $('#p' + i).attr('disabled', true);
        }
    }
}

function resetLectures() {
    for (i = 1; i <= 14; i++) {
        $('#r' + i).prop('checked', false);
        if ($("#r" + i).hasClass('hidden')){
            $('#r' + i).attr('disabled', false);
            $("#r" + i).removeClass('hidden');
        }
    }
}

function resetPosters() {
    for (i = 1; i <= 5; i++) {
        $('#p' + i).prop('checked', false);
        if ($("#p" + i).hasClass('hidden')){
            $("#p" + i).removeClass('hidden');
            $('#p' + i).attr('disabled', false);
        }
    }
}