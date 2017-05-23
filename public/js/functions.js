function highlightGreatest(selector) {
  var values = $(selector).map(function () {
    return +$(this).text(); // convert to number
  }).get(); // convert to array
  // Get the maximum value
  var max = Math.max.apply(Math, values);
  // Get position of where the maximum value is
  var index = values.indexOf(max);
  // Apply marking
  $(selector).eq(index).addClass('tick');
}
