//Set up event listeners for each button
document.getElementById("eventSubmit").addEventListener("click", addEvents, false);
document.getElementById("delete_btn").addEventListener("click", deleteEvent, false);
document.getElementById("eventEdit").addEventListener("click", editEvent, false);

//function used to add events, corresponds with addEvent.php, this code is largely based off wiki code
function addEvents() {
    const eventTime = document.getElementById("eventTime").value;
    const eventDate = document.getElementById("eventDate").value;
    const eventTitle = document.getElementById("eventTitle").value;
    const eventText = document.getElementById("eventText").value;

    //token
    // const eventToken = document.getElementById("eventToken").value;

    const data = {
        "eventTime" : eventTime,
        "eventTitle" : eventTitle,
        "eventDate" : eventDate,
        "eventText" : eventText
        //token
        // , "eventToken" : eventToken
    }
    fetch('addEvent.php', {
        method: 'POST',
        body: JSON.stringify(data),
        headers: { 'content-type': 'application/json' }
    })
    .then(response => response.json())
    .then(data => alert(data.success));

    //after submitting the menu, clear the forms
    document.getElementById("eventTime").value = "";
    document.getElementById("eventDate").value = "";
    document.getElementById("eventTitle").value = "";
    document.getElementById("eventText").value = "";

    //token
    document.getElementById("eventToken").value="";
}

//function used to delete events, corresponds with deleteEvent.php, this code is largely based off wiki code
function deleteEvent(){
  let eventid = document.getElementById("eventid").value; // Get the id from the form

  const data = {
      "eventid" : eventid
  }

  fetch('deleteEvent.php', {
      method: 'POST',
      body: JSON.stringify(data),
      headers: { 'content-type': 'application/json' }
  })
  .then(response => response.json())
  .then(function(data){
    if(data.success){//if successful, set all values of the page to null and refresh the page
      document.getElementById('titleDisplay').innerHTML = "";
      document.getElementById('timeDisplay').innerHTML = "";
      document.getElementById('detailDisplay').innerHTML = "";
      document.getElementById('IDDisplay').innerHTML = "";
      document.getElementById("eventid").value = "";
      clickDay();
      setup();
      console.log("ran it all");
    }
    else{
      console.log("failed");
    }
  })
}

//function used to edit events, corresponds with editEvent.php, this code is largely based off wiki code
function editEvent(){
  //get values from edit event menu
  const editEventID = document.getElementById("editEventID").value;
  const editEventTime = document.getElementById("editEventTime").value;
  const editEventDate = document.getElementById("editEventDate").value;
  const editEventTitle = document.getElementById("editEventTitle").value;
  const editEventText = document.getElementById("editEventText").value;

  const data = {
      "editEventID": editEventID,
      "editEventTime" : editEventTime,
      "editEventTitle" : editEventTitle,
      "editEventDate" : editEventDate,
      "editEventText" : editEventText
  }
  console.log(data);

  fetch('editEvent.php', {
      method: 'POST',
      body: JSON.stringify(data),
      headers: { 'content-type': 'application/json' }
  })
  .then(response => response.json())
  .then(function(data){
    if(data.success){//if successful, set all values of the page to null and refresh the page, on refresh values will be updated
      document.getElementById('titleDisplay').innerHTML = "";
      document.getElementById('timeDisplay').innerHTML = "";
      document.getElementById('detailDisplay').innerHTML = "";
      document.getElementById('IDDisplay').innerHTML = "";
      document.getElementById("eventid").value = "";
      clickDay();
      setup();
      console.log("ran it all");
    }
    else{
      console.log("failed");
    }
  })

  document.getElementById("editEventID").value = "";
  document.getElementById("editEventTime").value = "";
  document.getElementById("editEventDate").value = "";
  document.getElementById("editEventTitle").value = "";
  document.getElementById("editEventText").value = "";
}
