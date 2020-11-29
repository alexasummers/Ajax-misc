
$(document).ready(init);

var start_date; //the date that represents the start of the week


function init() {
    var date = new Date(); //current date-time
    date.setHours(0);
    date.setMinutes(0);
    date.setSeconds(0);
    show_week(date);
    $("#next-week").on("click", next);
    $("#prev-week").on("click", prev);
}

function prev() {
    start_date.setDate(start_date.getDate() - 7); //go one week back
    show_week(start_date);
}

function next() {
    start_date.setDate(start_date.getDate() + 7); //go one week forward
    show_week(start_date);
}

function show_week(date) {
    //show the range of the week at the top bar
    date.setDate(date.getDate() - date.getDay()); //get first Sunday
    start_date = new Date(date.getTime());
    var end_date = new Date(date.getTime());
    end_date.setDate(end_date.getDate() + 7);
    $("#week").text($.format.date(start_date, "MMM dd, yyyy") + " - " + $.format.date(end_date, "MMM dd, yyyy"));

    //make html for the calendar
    var html = makeCalendar(date);
    $("#calendar").html(html);

    //hide the details
    $("#details").css("display", "none");

    //show the events for this week
    get_events(start_date, end_date);
}

function getID(year,month,day,hour){
    return year +""+month +""+day +""+hour;
}

function makeCalendar(date) {
    var table_data = {days: [], hours: []};
    var o_date = new Date(date.getTime()); //set an original date/ime
    for (var i = 0; i < 7; ++i) {
        table_data["days"].push({Day: $.format.date(date, "E M/d")});
        date.setDate(date.getDate() + 1);//add a day
    }
    for (var j = 0; j < 24; ++j) {
        var row = {Hour: j, cells: []}
        date = new Date(o_date.getTime());//reset the day back to original date/time

        var cells = [];
        for (var k = 0; k < 7; ++k) {
            var month = date.getMonth() + 1;
            var day = date.getDate();
            var year = date.getFullYear();
            var id = getID(year,month,day,j);
            cells.push({ID: id});
            date.setDate(day + 1);//add a day
        }
        row["cells"] = cells;//add cells
        table_data["hours"].push(row); //add row
    }

    var calendar_template = $("#calendar-template").html();
    var html_maker = new htmlMaker(calendar_template);
    var html = html_maker.getHTML(table_data);
    return html;
}





function map_event(id,color,date,duration,name){
         $("#" + id).attr("class", color).attr("data-name", name).attr("data-date", date).attr("data-duration", duration + "h");
  
}




function show_events(data) {
    for (var i = 0; i < data.length; i++) {
        var row = data[i];
        var date = $.format.parseDateObject(row["StartDate"]);
        var duration = parseInt(row["Duration"]);
        var name = row["Name"];
        var month = date.getMonth() + 1;
        var day = date.getDate();
        var year = date.getFullYear();
        var hour = date.getHours();
        //make the id so that we locate the event on the calendar table
        var id = getID(year,month,day,hour);
        map_event(id,row["color"],date,duration,name);
        $("#"+id).text(name);


        var k = hour; //starting at this hour
        for (var j = 1; j < duration; j++) {
            k++;
            if (k > 23) { //if the duration goes beyond this day, extend to next day. 
                day++;
                k = 0;
            }
            id = getID(year,month,day,k);
            map_event(id,row["color"],date,duration,name);
        }
    }
}

function format_date(date) {
    return date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate() + " " + date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds() + "." + date.getMilliseconds();
}

function get_events(start_date, end_date) {
    $.ajax({
        method: "POST",
        url: "server/calendar.php",
        dataType: "json",
        data: {from: $.format.date(start_date, "yyyy-M-d HH:mm:s"), to: $.format.date(end_date, "yyyy-M-d HH:mm:s")},
        success: function (data) {
            show_events(data);
        }
    });
}



