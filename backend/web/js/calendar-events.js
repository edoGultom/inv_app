// sample calendar events data

"use strict";

var curYear = moment().format("YYYY");
var curMonth = moment().format("MM");

// Calendar Event Source
var calendarEvents = {
  id: 1,
  backgroundColor: "#d9e8ff",
  borderColor: "#0168fa",
  events: [
    {
      id: "1",
      start: curYear + "-" + curMonth + "-08T08:30:00",
      end: curYear + "-" + curMonth + "-08T13:00:00",
      title: "ThemeForest Meetup",
      description:
        "In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis az pede mollis...",
    },
    {
      id: "2",
      start: curYear + "-" + curMonth + "-10T09:00:00",
      end: curYear + "-" + curMonth + "-10T17:00:00",
      title: "Design Review",
      description:
        "In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis az pede mollis...",
    },
    {
      id: "3",
      start: curYear + "-" + curMonth + "-13T12:00:00",
      end: curYear + "-" + curMonth + "-13T18:00:00",
      title: "Lifestyle Conference",
      description:
        "Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi...",
    },
    {
      id: "4",
      start: curYear + "-" + curMonth + "-15T07:30:00",
      end: curYear + "-" + curMonth + "-15T15:30:00",
      title: "Team Weekly Brownbag",
      description:
        "In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis az pede mollis...",
    },
    {
      id: "5",
      start: curYear + "-" + curMonth + "-17T10:00:00",
      end: curYear + "-" + curMonth + "-19T15:00:00",
      title: "Music Festival",
      description:
        "In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis az pede mollis...",
    },
    {
      id: "6",
      start: curYear + "-" + curMonth + "-08T13:00:00",
      end: curYear + "-" + curMonth + "-08T18:30:00",
      title: "Attend Lea's Wedding",
      description:
        "In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis az pede mollis...",
    },
  ],
};
