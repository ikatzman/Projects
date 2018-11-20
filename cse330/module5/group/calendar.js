/* * * * * * * * * * * * * * * * * * * *\
 *               Module 4              *
 *      Calendar Helper Functions      *
 *                                     *
 *        by Shane Carr '15 (TA)       *
 *  Washington University in St. Louis *
 *    Department of Computer Science   *
 *               CSE 330S              *
 *                                     *
 *      Last Update: October 2017      *
\* * * * * * * * * * * * * * * * * * * */

/*  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

(function () {
  "use strict";

  /* Date.prototype.deltaDays(n)
   *
   * Returns a Date object n days in the future.
   */
  Date.prototype.deltaDays = function (n) {
    // relies on the Date object to automatically wrap between months for us
    return new Date(this.getFullYear(), this.getMonth(), this.getDate() + n);
  };

  /* Date.prototype.getSunday()
   *
   * Returns the Sunday nearest in the past to this date (inclusive)
   */
  Date.prototype.getSunday = function () {
    return this.deltaDays(-1 * this.getDay());
  };
}());

/** Week
 *
 * Represents a week.
 *
 * Functions (Methods):
 *	.nextWeek() returns a Week object sequentially in the future
 *	.prevWeek() returns a Week object sequentially in the past
 *	.contains(date) returns true if this week's sunday is the same
 *		as date's sunday; false otherwise
 *	.getDates() returns an Array containing 7 Date objects, each representing
 *		one of the seven days in this month
 */
function Week(initial_d) {
  "use strict";

  this.sunday = initial_d.getSunday();


  this.nextWeek = function () {
    return new Week(this.sunday.deltaDays(7));
  };

  this.prevWeek = function () {
    return new Week(this.sunday.deltaDays(-7));
  };

  this.contains = function (d) {
    return (this.sunday.valueOf() === d.getSunday().valueOf());
  };

  this.getDates = function () {
    var dates = [];
    for(var i=0; i<7; i++){
      dates.push(this.sunday.deltaDays(i));
    }
    return dates;
  };
}

/** Month
 *
 * Represents a month.
 *
 * Properties:
 *	.year == the year associated with the month
 *	.month == the month number (January = 0)
 *
 * Functions (Methods):
 *	.nextMonth() returns a Month object sequentially in the future
 *	.prevMonth() returns a Month object sequentially in the past
 *	.getDateObject(d) returns a Date object representing the date
 *		d in the month
 *	.getWeeks() returns an Array containing all weeks spanned by the
 *		month; the weeks are represented as Week objects
 */
function Month(year, month) {
  "use strict";

  this.year = year;
  this.month = month;

  this.nextMonth = function () {
    return new Month( year + Math.floor((month+1)/12), (month+1) % 12);
  };

  this.prevMonth = function () {
    return new Month( year + Math.floor((month-1)/12), (month+11) % 12);
  };

  this.getDateObject = function(d) {
    return new Date(this.year, this.month, d);
  };

  this.getWeeks = function () {
    var firstDay = this.getDateObject(1);
    var lastDay = this.nextMonth().getDateObject(0);

    var weeks = [];
    var currweek = new Week(firstDay);
    weeks.push(currweek);
    while(!currweek.contains(lastDay)){
      currweek = currweek.nextWeek();
      weeks.push(currweek);
    }

    return weeks;
  };
}


//EVERYTHING ABOVE WAS TAKEN FROM THE CSE330 WIKI^

//current month will be october for our purposes
let currentMonth = new Month(2018, 9);
//create cookie variable to track
let cookie;

//Clicking the next month button displays the next month
document.getElementById("next_month").addEventListener("click", function(event){
  currentMonth = currentMonth.nextMonth(); // Previous month would be currentMonth.prevMonth()
  updateCalendar(); // Whenever the month is updated, we'll need to re-render the calendar in HTML
  }, false);

//Clicking the previous month button displays the previous month
document.getElementById("last_month").addEventListener("click", function(event){
  currentMonth = currentMonth.prevMonth(); // Previous month would be currentMonth.prevMonth()
  updateCalendar(); // Whenever the month is updated, we'll need to re-render the calendar in HTML
  }, false);

  //When this function is called, the calendar and all its HTML elements are updateCalendar
  //The dates are filled into the calendar
  function updateCalendar(){
    let month = currentMonth.month;
    let year = currentMonth.year;

    if(month == 0){
      month = "January";
    }
    if(month == 1){
      month = "February";
    }
    if(month == 2){
      month = "March";
    }
    if(month == 3){
      month = "April";
    }
    if(month == 4){
      month = "May";
    }
    if(month == 5){
      month = "June";
    }
    if(month == 6){
      month = "July";
    }
    if(month == 7){
      month = "August";
    }
    if(month == 8){
      month = "September";
    }
    if(month == 9){
      month = "October";
    }
    if(month == 10){
      month = "November";
    }
    if(month == 11){
      month = "December";
    }

    let weeks = currentMonth.getWeeks();
    let i = 0;

  	for(let w in weeks){
  		let days = weeks[w].getDates();

      for(let d in days){
        let date = days[d].toISOString();
        let tens = date[8];
        let ones = date[9];

        let monthTens = date[5];
        let monthOnes = date[6];

        let yr_thsnds = date[0];
        let yr_hundrds = date[1];
        let yr_tens = date[2];
        let yr_ones = date[3];

        let dy = tens + "" + ones;
        let mnth = monthTens + "" + monthOnes;
        let yr = yr_thsnds + "" + yr_hundrds + "" + yr_tens + "" + yr_ones;

        document.getElementsByClassName("day")[i].innerHTML = dy + "<div class='hiddenMonth'>" + mnth + "</div>" + "<div class='hiddenYear'>" + yr + "</div>";
        document.getElementsByClassName("day")[i].addEventListener("click", clickDay, false);

        i++;
      }
  	}
    document.getElementById("month").innerHTML = month + " " + year;
 }

 //This function is called upon page loadin/refreshing, and shows or hides buttons based
 //on if a user is logged in or not
 function setup(){
   fetch("checklogin.php", {
       method: 'POST',
       headers: { 'content-type': 'application/json' }
   })
   .then(response => response.json())
   .then(function(data){
     if(data.success){
       cookieSet(data.token);
       hider();
       document.getElementsByClassName('confirm').innerHTML = "logged in";
     }
     else{
       document.getElementsByClassName('confirm').innerHTML = "not logged in";
     }
   });
   updateCalendar();
 }

 //Sets the cookie variable for login
 function cookieSet(temp_cookie){
   cookie = temp_cookie;
 }
 document.addEventListener("DOMContentLoaded", setup, false);
