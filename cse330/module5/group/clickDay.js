function clickDay(event) {
    let newarr = [];
    //day, month, year in numbers
    let day = event.currentTarget.firstChild.textContent;
    //document.getElementById('eventDisplay').innerHTML = day + " ";
    let month = event.currentTarget.firstChild.nextSibling.textContent;
    //document.getElementById('eventDisplay').innerHTML += month + " ";
    let year = event.currentTarget.firstChild.nextSibling.nextSibling.textContent;
    //document.getElementById('eventDisplay').innerHTML += year;

    const data = {
        "day" : day,
        "month" : month,
        "year" : year
    }

    fetch('clickDay2.php', {
        method: 'POST',
        body: JSON.stringify(data),
        headers: { 'content-type': 'application/json' }
    })
    .then(response => response.json())
    .then(function(data){
      if(data.success){
        let temparr = data.arr
        for(let i = 0; i<temparr.length; i++){
          console.log(temparr[i])
          for(let j=0; j<temparr[i].length; j++){
            if(temparr[i][j] != null){
              //if the array has contents, display the details of the event on the page
              document.getElementById('titleDisplay').innerHTML = temparr[i][4] + " ";
              document.getElementById('timeDisplay').innerHTML = temparr[i][1] + " ";
              document.getElementById('detailDisplay').innerHTML = temparr[i][0] + " ";
              document.getElementById('IDDisplay').innerHTML = temparr[i][2] + " ";
            }
            else{
              document.getElementById('noevent').innerHTML = "No event to display";
            }
          }
        }
      }
      else{
        document.getElementById('titleDisplay').innerHTML = "";
        document.getElementById('timeDisplay').innerHTML = "";
        document.getElementById('detailDisplay').innerHTML = "";
        document.getElementById('IDDisplay').innerHTML = "";
      }
    })
}
