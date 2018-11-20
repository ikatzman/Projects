function newUser(event){
    let username = document.getElementById("new_username").value; // Get the username from the form
    let password = document.getElementById("new_password").value; // Get the password from the form

    const data = { 'new_username': username, 'new_password': password };

    fetch('usersignup.php', {
            method: 'POST',
            body: JSON.stringify(data),
            headers: { 'content-type': 'application/json' }
        })
        .then(response => response.json())
        .then(data =>  alert(data.success ? "You've created an acct" : `${data.message}`));
        document.getElementById("new_username").value = "";
        document.getElementById("new_password").value = "";
} 

 document.getElementById("register_btn").addEventListener("click", newUser, false); // Bind the AJAX call to button click
