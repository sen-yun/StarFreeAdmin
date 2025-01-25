function getRandomDataArray(length) {
  var dataArray = [];
  for (var i = 0; i < length; i++) {
    dataArray.push(Math.floor(Math.random() * 100));
  }
  return dataArray;
}
var options1 = {
  chart: {
    type: "bar",
    height: 60,
    sparkline: {
      enabled: true
    }
  },
  plotOptions: {
    bar: {
      columnWidth: "60%"
    }
  },
  colors: ["#ffa3e1"],
  series: [{
    data: []
  }],
  labels: [],
  xaxis: {
    crosshairs: {
      width: 1
    }
  },
  tooltip: {
    fixed: {
      enabled: false
    },
    x: {
      show: true
    },
    y: {
      title: {
        formatter: function(e) {
          return "";
        }
      }
    },
    marker: {
      show: false
    }
  }
};

var labels = [];
for (var i = 9; i >= 0; i--) {
  var date = new Date();
  date.setDate(date.getDate() - i);
  var formattedDate = date.toLocaleDateString("zh-CN", { month: 'long', day: 'numeric' });
  labels.push(formattedDate);
}
options1.labels = labels;

  
var options12 = {
  chart: {
    type: "bar",
    height: 60,
    sparkline: {
      enabled: true
    }
  },
  plotOptions: {
    bar: {
      columnWidth: "60%"
    }
  },
  colors: ["#ffa3e1"],
  series: [{
    data: []
  }],
  labels: [],
  xaxis: {
    crosshairs: {
      width: 1
    }
  },
  tooltip: {
    fixed: {
      enabled: false
    },
    x: {
      show: true
    },
    y: {
      title: {
        formatter: function(e) {
          return "";
        }
      }
    },
    marker: {
      show: false
    }
  }
};

var labels = [];
for (var i = 9; i >= 0; i--) {
  var date = new Date();
  date.setDate(date.getDate() - i);
  var formattedDate = date.toLocaleDateString("zh-CN", { month: 'long', day: 'numeric' });
  labels.push(formattedDate);
}
options1.labels = labels;

fetch('../admin/getSignIns.php?dataType=contents')
  .then(response => response.json())
  .then(data => {
    options1.series[0].data = data;

    new ApexCharts(document.querySelector("#campaign-sent-chart3"), options1).render();
  })
  .catch(error => {
    console.error('Error:', error);
  });
var options11 = {
  chart: {
    type: "bar",
    height: 60,
    sparkline: {
      enabled: true
    }
  },
  plotOptions: {
    bar: {
      columnWidth: "60%"
    }
  },
  colors: ["#ffa3e1"],
  series: [{
    data: []
  }],
  labels: [],
  xaxis: {
    crosshairs: {
      width: 1
    }
  },
  tooltip: {
    fixed: {
      enabled: false
    },
    x: {
      show: true
    },
    y: {
      title: {
        formatter: function(e) {
          return "";
        }
      }
    },
    marker: {
      show: false
    }
  }
};

var labels = [];
for (var i = 9; i >= 0; i--) {
  var date = new Date();
  date.setDate(date.getDate() - i);
  var formattedDate = date.toLocaleDateString("zh-CN", { month: 'long', day: 'numeric' });
  labels.push(formattedDate);
}
options1.labels = labels;

fetch('../admin/getSignIns.php?dataType=commentCount')
  .then(response => response.json())
  .then(data => {
    options1.series[0].data = data;

    new ApexCharts(document.querySelector("#campaign-sent-chart2"), options1).render();
  })
  .catch(error => {
    console.error('Error:', error);
  });
var options2 = {
    chart: {
        type: "line",
        height: 60,
        sparkline: {
            enabled: !0
        }
    },
    series: [{
        data: getRandomDataArray(11)
    }],
    stroke: {
        width: 2,
        curve: "smooth"
    },
    markers: {
        size: 0
    },
    colors: ["#ffa3e1"],
    tooltip: {
        fixed: {
            enabled: !1
        },
        x: {
            show: !1
        },
        y: {
            title: {
                formatter: function(e) {
                    return ""
                }
            }
        },
        marker: {
            show: !1
        }
    }
};
new ApexCharts(document.querySelector("#new-leads-chart"), options2).render();
var options3 = {
    chart: {
        type: "bar",
        height: 60,
        sparkline: {
            enabled: !0
        }
    },
    plotOptions: {
        bar: {
            columnWidth: "60%"
        }
    },
    colors: ["#ffa3e1"],
    series: [{
        data: getRandomDataArray(11)
    }],
    labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
    xaxis: {
        crosshairs: {
            width: 1
        }
    },
    tooltip: {
        fixed: {
            enabled: !1
        },
        x: {
            show: !1
        },
        y: {
            title: {
                formatter: function(e) {
                    return ""
                }
            }
        },
        marker: {
            show: !1
        }
    }
};
new ApexCharts(document.querySelector("#deals-chart"), options3).render();
var options4 = {
    chart: {
        type: "bar",
        height: 60,
        sparkline: {
            enabled: !0
        }
    },
    plotOptions: {
        bar: {
            columnWidth: "60%"
        }
    },
    colors: ["#ffa3e1"],
    series: [{
        data: getRandomDataArray(11)
    }],
    labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
    xaxis: {
        crosshairs: {
            width: 1
        }
    },
    tooltip: {
        fixed: {
            enabled: !1
        },
        x: {
            show: !1
        },
        y: {
            title: {
                formatter: function(e) {
                    return ""
                }
            }
        },
        marker: {
            show: !1
        }
    }
};
new ApexCharts(document.querySelector("#booked-revenue-chart"), options4).render();
var options = {
    chart: {
        height: 320,
        type: "radialBar"
    },
    colors: ["#ffbc00", "#ffa3e1", "#ffa3e1"],
    series: [86, 36, 50],
    labels: ["Total Sent", "Reached", "Opened"],
    plotOptions: {
        radialBar: {
            track: {
                margin: 8
            }
        }
    }
};
(chart = new ApexCharts(document.querySelector("#dash-campaigns-chart"), options)).render();
var chart;
options = {
    chart: {
        height: 336,
        type: "line",
        toolbar: {
            show: !1
        }
    },
    stroke: {
        curve: "smooth",
        width: 2
    },
    series: [ {
        name: "Total Pipeline",
        type: "line",
        data: [55, 69, 45, 61, 43, 54, 37, 52, 44, 61, 43, 56]
    }],
    fill: {
        type: "solid",
        opacity: [.35, 1]
    },
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    markers: {
        size: 0
    },
    colors: ["#ffa3e1", "#fa5c7c"],
    yaxis: [{
        title: {
            text: "Revenue (USD)"
        },
        min: 0
    }],
    tooltip: {
        shared: !0,
        intersect: !1,
        y: {
            formatter: function(e) {
                return void 0 !== e ? e.toFixed(0) + "k" : e
            }
        }
    },
    grid: {
        borderColor: "#f1f3fa"
    },
    legend: {
        fontSize: "14px",
        fontFamily: "14px",
        offsetY: -10
    },
    responsive: [{
        breakpoint: 600,
        options: {
            yaxis: {
                show: !1
            },
            legend: {
                show: !1
            }
        }
    }]
};
(chart = new ApexCharts(document.querySelector("#dash-revenue-chart"), options)).render();