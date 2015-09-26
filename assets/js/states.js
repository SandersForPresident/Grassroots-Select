(function ($, d3) {
  function Map ($target) {
    var width = $target.width(),
        height = $target.height(),
        halfWidth = width / 2,
        halfHeight = height / 2,
        path = d3.geo.path().projection(null),
        topo = null,
        stateColors = {};
        svg = d3.select('#map')
          .append('svg')
          .attr('width', width)
          .attr('height', height)
          .attr('viewBox', '85 5 ' + width + ' ' + height)
          .attr('preserveAspetRatio', 'xMidYMin'),
        districtFeatures = svg.append('g').classed('districts', true),
        stateFeatures = svg.append('g').classed('states', true),
        zoom = d3.behavior.zoom(),
        colorKey6blue = ['rgb(199,233,180)','rgb(127,205,187)','rgb(65,182,196)','rgb(29,145,192)','rgb(34,94,168)','rgb(12,44,132)'],
        colorKey6red = ["rgb(255,213,125)","rgb(255,184,97)","rgb(255,138,72)","rgb(254,80,54)","rgb(228,38,41)","rgb(165,24,42)"];

    svg.call(zoom).on('dblclick.zoom', null);

    function buildStates () {
      stateFeatures.selectAll('path')
        .data(topojson.feature(topo, topo.objects.states).features)
        .enter()
        .append('path')
        .attr('d', path)
        .attr('class', 'state-border');
    }

    function buildDistricts () {
      districtFeatures.selectAll('path')
        .data(topojson.feature(topo, topo.objects.districts).features)
        .enter()
        .append('path')
        .attr('d', path)
        .attr('class', function (d) {
          return 'district ' + d.id;
        })
        .attr('fill', function (d) {
          var state = d.id.split('-');
          state = state[0];
          var color = stateColors[state];
          var random = Math.floor(Math.random() * 5);
          return [colorKey6blue, colorKey6red][color][random];
          return colorKey6blue[random];
        })
        .on('mouseout', function () {
          hideTooltip();
        })
        .on('mousemove', function (d) {
          showTooltip(d, d3.event);
        })
        .on('click', function (d) {
          showInfoWindow(d);
          zoomToDistrict(this);
        });
    }

    function zoomToDistrict (element) {
      var box = d3.select(element).node().getBBox();
      var boxArea = box.width * box.height;
      var zoomX = box.x + box.width/2;
      var zoomY = box.y + box.height/2;
      var scale = 2;
      var translate = zoom.translate();

      d3.select('.district.selected').classed('selected', false);
      d3.select(element).classed('selected', true);

      if (boxArea < 30) {
        scale = 12;
      } else if (boxArea < 200) {
        scale = 8;
      } else if (boxArea < 2200) {
        scale = 4;
      } else {
        scale = 2;
      }

      translate[0] = -((zoomX * scale) - (width / 1.35));

      if (zoomY < 130) {
        translate[1] = -((zoomY * scale) - (height / 4));
      } else {
        translate[1] = -((zoomY * scale) - (height / 2));
      }

      translate[0] = Math.min(
        (width / 2 - halfWidth + 150) * (scale - 1),
        Math.max((width / 2 + halfWidth + 125) * (1 - scale), translate[0])
      );

      translate[1] = Math.min(
        (height / 2 - halfWidth + 155) * (scale - 1),
        Math.max((height / 2 + halfWidth - 120) * (1 - scale), translate[1])
      );
      zoom.scale(scale).translate(translate);


      districtFeatures.transition().duration(500)
        .attr('transform', 'translate(' + translate + ')scale(' + scale + ')')
      stateFeatures.transition().duration(500)
        .attr('transform', 'translate(' + translate + ')scale(' + scale + ')')
    }

    function showInfoWindow (data) {
      $('#infowindow').show();
      $('#infowindow h2 span').text(data.id);
    }

    function showTooltip (data, event) {
      $('#tooltip').show();
      $('#tooltip span').text(data.id);
      $('#tooltip').css({top: event.pageY + 20, left: event.pageX - 10});
    }

    function hideTooltip () {
      $('#tooltip').hide();
    }


    d3.json('/wp-content/themes/GrassrootsSelectTheme/districts2.json', function (error, data) {
      topo = data
      topo.objects.districts.geometries.forEach(function (item) {
        var state = item.id.split('-');
        state = state[0];
        if (!(state in stateColors)) {
          stateColors[state] = Math.floor(Math.random() * 2);
        }
      });
      console.log(stateColors);
      buildStates();
      buildDistricts();
    });
  }


  $(document).ready(function () {
    Map($("#map"));
  });
}).call(this, window.jQuery, window.d3);
