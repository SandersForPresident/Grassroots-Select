(function ($, d3) {

  function createMap () {
    var $target = $('#map'),
        width = $target.width(),
        height = $target.height(),
        projection = d3.geo.albersUsa()
          .scale(1280)
          .translate([width / 2, height / 2]),
        path = d3.geo.path().projection(projection),
        svg = d3.select('#map').append('svg').attr('width', width).attr('height', height);

    d3.json('/wp-content/themes/GrassrootsSelectTheme/us.json', function (error, us) {
      d3.json('/wp-content/themes/GrassrootsSelectTheme/districts.json', function (error, districts) {
        console.log('districts', error, districts);
        svg.append('defs')
          .append('path')
          .attr('id', 'land')
          .datum(topojson.feature(us, us.objects.land))
          .attr('d', path);

        svg.append('clipPath')
          .attr('id', 'clip-land')
          .append('use')
          .attr('xlink:href', '#land');

        svg.append('g')
          .attr('class', 'districts')
          .attr('clip-path', 'url(#clip-land)')
          .selectAll('path')
            .data(topojson.feature(districts, districts.objects.districts).features)
            .enter()
            .append('path')
            .attr('d', path)
            .append('title')
            .text(function (d) { return d.id; });

        svg.append('g')
          .attr('class', 'states')
          .attr('clip-path', 'url(#clip-land)')
          .selectAll('path')
          .data(topojson.feature(us, us.objects.states).features)
            .enter()
            .append('path')
            .attr('d', path);

        // svg.append('path')
        //   .attr('class', 'state-boundaries')
        //   .datum(topojson.mesh(us, us.objects.states, function(a, b) { return a !== b; }))
        //   .attr('d', path);
      });
    });
  }

  $(document).ready(createMap);
}).call(this, window.jQuery, window.d3);
