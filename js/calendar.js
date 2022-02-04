$(document).ready(function () {
  var date = new Date();
  var d = date.getDate();
  var m = date.getMonth();
  var y = date.getFullYear();

  var calendar = $("#calendar").fullCalendar({
    timeZone: 'Asia/Tokyo',
    locale: 'ja',
    businessHours:true,
    editable: true,
    eventColor: '#DF797F',
    header: {
      left: "prev today",
      center: "title",
      // right: "month,agendaWeek,agendaDay",
      right: "month next",

    },
    events: "./calendar/events.php",
    eventRender: function (event, element, view) {
      if (event.allDay === "true") {
        event.allDay = true;
      } else {
        event.allDay = false;
      }
    },
    timeFormat:"h:mm",
    selectable: true,
    selectHelper: true,
    
    
    select: function (start, end, allDay) {
      var title = prompt("追加するイベント名に入力してください:");
      if (title) {
        var today = new Date();
        var time = today.getHours() + ":" + ('0'+today.getMinutes()).slice(-2) + ":" + today.getSeconds();
        var start = $.fullCalendar.formatDate(start, "Y-MM-DD").toString() + " " + time.toString();
        var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
        $.ajax({
          url: "./calendar/add_events.php",
          data: "title=" + title + "&start=" + start + "&end=" + end,
          type: "POST",
          success: function (json) {
            alert("イベント追加が完了しました。");
          },
        });
        calendar.fullCalendar(
          "renderEvent",
          {
            title: title,
            start: start,
            end: end,
            allDay: allDay,
          },
          true
        );
      }
      calendar.fullCalendar("unselect");
    },
    editable: true,

    eventDrop: function (event, delta) {
      var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
      var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
      $.ajax({
        url: "./calendar/update_events.php",
        data:
          "title=" +
          event.title +
          "&start=" +
          start +
          "&end=" +
          end +
          "&id=" +
          event.id,
        type: "POST",
        success: function (json) {
          alert("イベント更新が完了しました");
        },
      });
    },

    eventClick: function (event) {
      var decision = confirm("このイベントが完全に削除してもよろしいですか?");
      if (decision) {
        $.ajax({
          type: "POST",
          url: "./calendar/delete_events.php",
          data: "&id=" + event.id,
          success: function (json) {
            $("#calendar").fullCalendar("removeEvents", event.id);
            alert("イベント削除が完了しました。");
          },
        });
      }
    },

    eventResize: function (event) {
      var start = $.fullCalendar.formatDate(event.start, "yyyy-MM-dd HH:mm:ss");
      var end = $.fullCalendar.formatDate(event.end, "yyyy-MM-dd HH:mm:ss");
      $.ajax({
        url: "./calendar/update_events.php",
        data:
          "title=" +
          event.title +
          "&start=" +
          start +
          "&end=" +
          end +
          "&id=" +
          event.id,
        type: "POST",
        success: function (json) {
          alert("イベント更新が完了しました。");
        },
      });
    },

  });
});
