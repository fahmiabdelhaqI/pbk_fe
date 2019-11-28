/**
 * Updates the donut chart's percent number and the CSS positioning of the progress bar.
 * Also allows you to set if it is a donut or pie chart
 * @param  {string}  el      The selector for the donut to update. '#thing'
 * @param  {number}  percent Passing in 22.3 will make the chart show 22%
 * @param  {boolean} donut   True shows donut, false shows pie
 */
function updateDonutChart (el, percent, donut) {
    percent = Math.round(percent);
    if (percent > 100) {
        percent = 100;
    } else if (percent < 0) {
        percent = 0;
    }
    var deg = Math.round(360 * (percent / 100));

    if (percent > 50) {
        $(el + ' .pie').css('clip', 'rect(auto, auto, auto, auto)');
        $(el + ' .right-side').css('transform', 'rotate(180deg)');
    } else {
        $(el + ' .pie').css('clip', 'rect(0, 1em, 1em, 0.5em)');
        $(el + ' .right-side').css('transform', 'rotate(0deg)');
    }

    /*** Rating Score ***/
    if(percent > 80 && percent <= 100)
    {
        $(el + ' .half-circle').css('border', '0.1em solid #006602');
    }
    else if(percent > 60 && percent <= 80)
    {
        $(el + ' .half-circle').css('border', '0.1em solid #00A303');
    }
    else if(percent > 40 && percent <= 60)
    {
        $(el + ' .half-circle').css('border', '0.1em solid #E0A500');
    }
    else if(percent > 20 && percent <= 40)
    {
        $(el + ' .half-circle').css('border', '0.1em solid #E00000');
    }
    else
    {
        $(el + ' .half-circle').css('border', '0.1em solid #E00000');
    }
    /*** End of Rating Score ***/

    if (donut) {
        $(el + ' .right-side').css('border-width', '0.1em');
        $(el + ' .left-side').css('border-width', '0.1em');
        $(el + ' .shadow').css('border-width', '0.1em');
    } else {
        $(el + ' .right-side').css('border-width', '0.5em');
        $(el + ' .left-side').css('border-width', '0.5em');
        $(el + ' .shadow').css('border-width', '0.5em');
    }
    $(el + ' .num').text(percent);
    $(el + ' .left-side').css('transform', 'rotate(' + deg + 'deg)');
}
