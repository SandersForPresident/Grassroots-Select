(function ($, d3) {
  function Map ($target) {
    var width = $target.width(),
        height = $target.height(),
        halfWidth = width / 2,
        halfHeight = height / 2,
        path = d3.geo.path().projection(null),
        topo = null,
        svg = d3.select('#map')
          .append('svg')
          .attr('width', width)
          .attr('height', height)
          .attr('viewBox', '85 5 ' + width + ' ' + height)
          .attr('preserveAspetRatio', 'xMidYMin'),
        districtFeatures = svg.append('g').classed('districts', true),
        stateFeatures = svg.append('g').classed('states', true),
        zoom = d3.behavior.zoom();

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
        .on('click', function (d) {
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


    d3.json('/wp-content/themes/GrassrootsSelectTheme/districts2.json', function (error, data) {
      topo = data
      buildStates();
      buildDistricts();
    });
  }


  $(document).ready(function () {
    Map($("#map"));
  });
}).call(this, window.jQuery, window.d3);
