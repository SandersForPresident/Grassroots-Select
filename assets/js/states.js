(function ($, d3) {

  function createMap () {
    var $target = $('#map'),
        width = $target.width(),
        height = $target.height(),
        path = d3.geo.path().projection(null),
        svg = d3.select('#map').append('svg').attr('width', width).attr('height', height);

    d3.json('/wp-content/themes/GrassrootsSelectTheme/districts2.json', function (error, topo) {
      var stateFeatures = svg.append('g').classed('states', true),
          districtFeatures = svg.append('g').classed('districts', true);

      stateFeatures.selectAll('path')
        .data(topojson.feature(topo, topo.objects.states).features)
        .enter()
        .append('path')
        .attr('d', path)
        .attr('class', 'state-border');

      districtFeatures.selectAll('path')
        .data(topojson.feature(topo, topo.objects.districts).features)
        .enter()
        .append('path')
        .attr('d', path)
        .attr('class', 'district-border');
    });
  }

  $(document).ready(createMap);
}).call(this, window.jQuery, window.d3);
