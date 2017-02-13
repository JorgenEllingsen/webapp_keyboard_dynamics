var EventBuffer = [];
var last_event = null;

function sendEvents(pending) {
    $.post("post-endpoint.php", {user: JSON.stringify($('#participant').val()), keyboard: JSON.stringify($('#keyboard').val()), events: JSON.stringify(pending)});
}

function StreamEvent(event) {
    var ev = {
        timestamp: event.timeStamp,
        key: event.key,
        type: event.type,
    };

    if (event.key == 'Enter') {
        if (event.type == 'keyup') {
            if($('#participant').val() == 0 || $('#keyboard').val() == 0) alert('Please select participant and keyboard to submit.');
            else
            {
                Pending = EventBuffer;
                EventBuffer = [];
                sendEvents(Pending);
                $('#entries').prepend('<div class="entry">'+ $('p').text() +'</div>');
                $('p').empty();
            }
        }
    }
    else
    {
        if($('#participant').val() != 0 || $('#keyboard').val() != 0) {
            if(event.type == 'keydown') $('p').append([ev.key]);
            EventBuffer.push(ev);
        }
    }



    last_event = event;
}

$(document).keydown(StreamEvent);
$(document).keyup(StreamEvent);
