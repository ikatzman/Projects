function loginAjax(event) {
   let username = document.getElementById("username").value; // Get the username from the form
   let password = document.getElementById("password").value; // Get the password from the form

   // Make a URL-encoded string for passing POST data:
   const data = {'username': username, 'password': password};

   fetch('login_ajax.php', {
           method: 'POST',
           body: JSON.stringify(data),
           headers: { 'content-type': 'application/json' }
       })
       .then(response => response.json())
       .then(data => {
            console.log(data.success ? hider(): `You were not logged in ${data.message}`);
            var jsonData = JSON.parse(JSON.stringify(data));
            token = jsonData.token;
            document.getElementsByClassName('confirm').innerHTML = username + " is logged in";
            updateCalendar()
        })
        document.getElementById("username").value = "";
        document.getElementById("password").value = "";


}
//hider shows and hides certain html elements that should and shouldnt be shown for a logged in user
//uses JQuery functions
function hider(){
  $(document).ready(function(){
    $("#username").hide();
    $("#password").hide();
    $("#login_btn").hide();
    $("#logout_btn").show();
    $("#new_username").hide();
    $("#new_password").hide();
    $("#register_btn").hide();
    $("#newusermessage").hide();
    $("#delete_btn").show();
    $("#eventid").show();
    $("#panel").show();
    $("#panel2").show();
    $("#instr").show();
  });

}

document.getElementById("login_btn").addEventListener("click", loginAjax, false); // Bind the AJAX call to button click
