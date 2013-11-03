var NeatlineTime = {
  resizeTimerID: null,

  resizeTimeline: function() {
     if (resizeTimerID == null) {
        resizeTimerID = window.setTimeout(function() {
            resizeTimerID = null;
            tl.layout();
        }, 500);
    }
  },

  loadTimeline: function(timelineId, timelineData, timelineStartDate) {
    var eventSource = new Timeline.DefaultEventSource();

    var defaultTheme = Timeline.getDefaultTheme();
    defaultTheme.mouseWheel = 'zoom';

    var bandInfos = [
        Timeline.createBandInfo({
            date:           timelineStartDate,
            eventSource:    eventSource,
            width:          "90%",
            intervalUnit:   Timeline.DateTime.MONTH, // WEEK, YEAR, MONTH
            intervalPixels: 100,
            date: "Nov 1 1965 00:00:00 GMT",
            zoomIndex:      10,
            zoomSteps:      new Array(
              {pixelsPerInterval: 280,  unit: Timeline.DateTime.HOUR},
              {pixelsPerInterval: 140,  unit: Timeline.DateTime.HOUR},
              {pixelsPerInterval:  70,  unit: Timeline.DateTime.HOUR},
              {pixelsPerInterval:  35,  unit: Timeline.DateTime.HOUR},
              {pixelsPerInterval: 400,  unit: Timeline.DateTime.DAY},
              {pixelsPerInterval: 200,  unit: Timeline.DateTime.DAY},
              {pixelsPerInterval: 100,  unit: Timeline.DateTime.DAY},
              {pixelsPerInterval:  50,  unit: Timeline.DateTime.DAY},
              {pixelsPerInterval: 400,  unit: Timeline.DateTime.MONTH},
              {pixelsPerInterval: 200,  unit: Timeline.DateTime.MONTH},
              {pixelsPerInterval: 100,  unit: Timeline.DateTime.MONTH} // DEFAULT zoomIndex
            )
        }),
        Timeline.createBandInfo({
            date:           timelineStartDate,
            overview:       true,
            eventSource:    eventSource,
            width:          "10%",
            intervalUnit:   Timeline.DateTime.YEAR, // DECADE, YEAR
            intervalPixels: 200,
            date: "Nov 1 1965 00:00:00 GMT"
        })
    ];

    bandInfos[1].syncWith = 0;
    bandInfos[1].highlight = true;

    tl = Timeline.create(document.getElementById(timelineId), bandInfos);
    tl.loadJSON(timelineData, function(json, url) {
        eventSource.loadJSON(json, url);
    });

  }
};
