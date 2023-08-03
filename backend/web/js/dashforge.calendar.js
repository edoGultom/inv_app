$(function () {
  "use strict";

  // Initialize fullCalendar
  $("#calendar").fullCalendar({
    // height: "parent",
    // header: {
    //   left: "prev,next today",
    //   center: "title",
    //   right: "listWeek,month",
    // },
    // navLinks: true,
    // selectable: true,
    selectLongPressDelay: 100,
    defaultView: "listWeek",
    views: {
      listWeek: {
        listDayFormat: "ddd DD",
        listDayAltFormat: false,
      },
    },

    eventSources: [calendarEvents],
    // eventAfterAllRender: function (view) {
    //   if (view.name === "listMonth" || view.name === "listWeek") {
    //     var dates = view.el.find(".fc-list-heading-main");
    //     dates.each(function () {
    //       var text = $(this).text().split(" ");
    //       var now = moment().format("DD");

    //       $(this).html(text[0] + "<span>" + text[1] + "</span>");
    //       if (now === text[1]) {
    //         $(this).addClass("now");
    //       }
    //     });
    //   }
    // },
    eventRender: function (event, element) {
      if (event.description) {
        element
          .find(".fc-list-item-title")
          .append('<span class="fc-desc">' + event.description + "</span>");
        element
          .find(".fc-content")
          .append('<span class="fc-desc">' + event.description + "</span>");
      }

      var eBorderColor = event.source.borderColor
        ? event.source.borderColor
        : event.borderColor;
      element.find(".fc-list-item-time").css({
        color: eBorderColor,
        borderColor: eBorderColor,
      });

      element.find(".fc-list-item-title").css({
        borderColor: eBorderColor,
      });

      element.css("borderLeftColor", eBorderColor);
    },
  });
});
