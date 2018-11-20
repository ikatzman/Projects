function logoutAjax(event) {
  const username = document.getElementById("username").value; // Get the username from the form
  const password = document.getElementById("password").value; // Get the password from the form

  const data = { 'username': username, 'password': password };
  console.log(data);
  fetch("logout_ajax.php", {
      method: 'POST',
      body: JSON.stringify(data),
      headers: { 'content-type': 'application/json' }
  })
  .then(response => response.json())
  .then(data => data.success ? shower(): alert(`You were not logged out ${data.message}`));
  document.getElementsByClassName('confirm').innerHTML = "logged out";
  updateCalendar()
}

//shower shows and hides certain html elements that should and shouldnt be shown for a logged out user
//uses JQuery functions
function shower(){
  $(document).ready(function(){
    $("#username").show();
    $("#password").show();
    $("#login_btn").show();
    $("#logout_btn").hide();
    $("#new_username").show();
    $("#new_password").show();
    $("#register_btn").show();
    $("#newusermessage").show();
    $("#delete_btn").hide();
    $("#eventid").hide();
    $("#delete_btn").hide();
    $("#instructions").hide();
    $("#panel").hide();
    $("#panel2").hide();
    $("#instr").hide();
  });
}
document.getElementById("logout_btn").addEventListener("click", logoutAjax, false); // Bind the AJAX call to button click
