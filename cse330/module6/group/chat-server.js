// Require the packages we will use:
var http = require("http"),
	socketio = require("socket.io"),
	fs = require("fs");

// Listen for HTTP connections.  This is essentially a miniature static file server that only serves our one file, client.html:
var app = http.createServer(function (request, response) {
  if (request.url === "/chatroom.css") {
    fs.readFile("chatroom.css", function(err, data){
      if (err) return response.writeHead(500);
      response.writeHead(200, {"Content-Type": "text/css"});
      response.end(data);
    })
  }
  else {
    response.writeHead(200, {"Content-Type": "text/html"});
    fs.readFile("client.html", function(err, data){
      if(err) return response.writeHead(500);
      response.writeHead(200);
      response.end(data);
    });
  }
})
app.listen(3456);

var count = 0;
var roomUsers = new Array();
var user_array = new Array();
var publicNames = new Array();
var privateNames = new Array();
var privateDict = {};
var userList = {};
var userList2 = {};
var localRm = {};
var blackList = {};


var creatorList2 = {};
var creatorList = {};
var banList = {};
publicNames.push('lobby');
privateNames.push('');

//console.log(publicNames);

// Do the Socket.IO magic:
var io = socketio.listen(app);
io.sockets.on("connection", function(socket){
	// This callback runs when a new Socket.IO connection is established.
	// sockets.on("create_room", function(create_room)){
	// 	rooms.push({roomName:addRoom});
	// });
	// console.log(publicNames);

		socket.on('message_to_server', function(data) {
		// This callback runs when the server receives a new message from the client.

		io.sockets.emit("message_to_client",{message:data["message"] }) // broadcast the message to other users
	});

	socket.on("message_to_group", function(data) {
		// This callback runs when the server receives a new message from the client.
		io.to(socket.room).emit("message_to_client", {message:data["message"], user:userList[socket.id]}); // broadcast the message to other users
	});

	socket.on("emoji_1", function(data) {
		// This callback runs when the server receives a new message from the client.
		io.to(socket.room).emit("display_emoji_1", {message:data["emj"], user:userList[socket.id]}); // broadcast the message to other users
	});

	socket.on("emoji_2", function(data) {
		// This callback runs when the server receives a new message from the client.
		io.to(socket.room).emit("display_emoji_2", {message:data["emj"], user:userList[socket.id]}); // broadcast the message to other users
	});

	socket.on("emoji_3", function(data) {
		// This callback runs when the server receives a new message from the client.
		io.to(socket.room).emit("display_emoji_3", {message:data["emj"], user:userList[socket.id]}); // broadcast the message to other users
	});

	socket.on("emoji_4", function(data) {
		// This callback runs when the server receives a new message from the client.
		io.to(socket.room).emit("display_emoji_4", {message:data["emj"], user:userList[socket.id]}); // broadcast the message to other users
	});

	socket.on("emoji_5", function(data) {
		// This callback runs when the server receives a new message from the client.
		io.to(socket.room).emit("display_emoji_5", {message:data["emj"], user:userList[socket.id]}); // broadcast the message to other users
	});

	socket.on("emoji_6", function(data) {
		// This callback runs when the server receives a new message from the client.
		io.to(socket.room).emit("display_emoji_6", {message:data["emj"], user:userList[socket.id]}); // broadcast the message to other users
	});
	// socket.on('add_user', function(username){
	// 	console.log(socket.id);
	// 	io.sockets.emit("current_user", {currUsers:currentUsers});
	// });

	// Creating list of public chat rooms
	socket.on('private_chat_room', function(data) {
		privateDict[data['privName']] = data['pass'];
		creatorList2[data['privName']] = data['roomCreator'];
		console.log("data[privName]" + data['privName'] + " privateNames" + privateNames);
		for(var e in privateNames){
			if(data['privName'] == privateNames[e]){
				count++;
				break;
			}
		}

		if(count >= 1){
			count = 0;
			socket.emit("privateRoomnameInUse", {room:privateNames[e]});
		}
		else{
			count = 0;
			privateNames.push(data["privName"]);
			io.sockets.emit("priv_names", {name:data['privName'], user:userList[socket.id], list:creatorList2});
		}
	});


	socket.on('public_chat_room', function(data) {
		creatorList[data['pubName']] = data['roomCreator'];
		for(var e in publicNames){
			if(data['pubName'] == publicNames[e]){
				count++;
				break;
			}
		}

		if(count >= 1){
			count = 0;
			socket.emit("roomnameInUse", {room:publicNames[e]});
		}
		else{
			count = 0;
			publicNames.push(data["pubName"]);
			io.sockets.emit("pub_names", {pubNames:publicNames, user:userList[socket.id], list:creatorList});
		}
	});

	socket.on('display_users', function(data) {
		//user_array.push(data['user2']);
		// console.log(socket.id);
		//console.log("SOCKET " + socket);
		socket.join('lobby');
		socket.username = data['user2'];
		// socket.room = 'lobby';
		//console.log("socket.username " + socket.username);
		// roomUsers.push(socket.username);
		// console.log("USERNAMEs " + roomUsers[0] + roomUsers[1]);
		// user_id.push(socket.id);
		//socket.set('nickname', 'Guest');
		userList[socket.id] = data['user2'];
		userList2[data['user2']] = socket.id;
		// console.log(userList);
		io.to('lobby').emit("initialization", {user4:userList});
		socket.emit("initialization2", {public:publicNames, priv:privateDict});


		for(var e in userList){
			//console.log(userList[socket.id]);
			//console.log(userList[e]);
			if(userList[socket.id] == userList[e]){
				count++;
			}
		}

		if(count > 1){
			count = 0;
			socket.emit("usernameInUse", {cUser:userList[e]});
		}
		else{
			count = 0;
		}
		// io.sockets.emit("display_curr", {user5:user_id});
	});
	// Joins the correct room
	// Creating a list of private chat rooms


	// Checks and joins the correct private room
	socket.on('join_priv', function(data) {
		socket.leave('lobby');
		var room = data['privName'];
		var pass = data['pass'];

		var isBlack = true;
		if(room in blackList){
			for(var l = 0; l < blackList[room].length; l ++){
				if(socket.username == blackList[room][l]){
					isBlack = false;
				}
			}
		}

		if(isBlack == true){
			if(privateDict[room] == pass){
				socket.room = room;
				socket.join(room);
				for(var i in localRm){
					if(localRm[i].includes(socket.username)){
						if(room != i){
							var index = localRm[i].indexOf(socket.username);
							localRm[i].splice(index, 1);
							socket.leave(i);
							io.to(i).emit('user_names', {list:localRm, currRm:i});
						}
					}
				}

				if(!(room in localRm)){
					localRm[room] = [socket.username];
					io.to(socket.room).emit('user_names', {list:localRm, currRm:socket.room});
				}else{
					localRm[room].push(socket.username);
					io.to(socket.room).emit('user_names', {list:localRm, currRm:socket.room});
				}
			}else{
				console.log("password didn't match");
			}
		}
	});

	// Joins the correct public room
	socket.on('join_pub', function(data) {
		socket.leave('lobby');
		var room = data['roomName'];

		var isBlack = true;
		if(room in blackList){
			for(var l = 0; l < blackList[room].length; l ++){
				if(socket.username == blackList[room][l]){
					isBlack = false;
				}
			}
		}

		if(isBlack == true){
			console.log("is it going here?");
			socket.room = room;
			socket.join(room);
			for(var i in localRm){
				if(localRm[i].includes(socket.username)){
					if(room != i){
						console.log("splice "+ i);
						var index = localRm[i].indexOf(socket.username);
						localRm[i].splice(index, 1);
						socket.leave(i);
						io.to(i).emit('user_names', {list:localRm, currRm:i});
					}
				}
			}

			if(!(room in localRm)){
				localRm[room] = [socket.username];
				io.to(socket.room).emit('user_names', {list:localRm, currRm:socket.room});
			}else{
				localRm[room].push(socket.username);
				io.to(socket.room).emit('user_names', {list:localRm, currRm:socket.room});
			}
		}
	});

	// // Joins the correct public room
	// socket.on('join_pub', function(data) {
	// 	socket.leave('lobby');
	// 	var room = data['roomName'];
	// 	// var splice = false;
	// 	socket.room = room;
	// 	socket.join(room);
	// 	for(var i in localRm){
	// 		if(localRm[i].includes(socket.username)){
	// 			//console.log("socket.user " + socket.username);
	// 			if(room != i){
	// 				//console.log("This shouldn't be running");
	// 				var index = localRm[i].indexOf(socket.username);
	// 				localRm[i].splice(index, 1);
	// 				//console.log(socket.username + 'left' + i);
	// 				//console.log("before leaving" + localRm[i]);
	// 				socket.leave(i);
	// 				io.to(i).emit('user_names', {list:localRm, currRm:i});
	// 			}
	// 		}
	// 	}
	//
	// 	if(!(room in localRm)){
	// 		localRm[room] = [socket.username];
	// 		//console.log('new socketroom' + socket.room);
	// 		io.to(socket.room).emit('user_names', {list:localRm, currRm:socket.room});
	// 	}else{
	// 		localRm[room].push(socket.username);
	// 		//console.log('new socketroom' + socket.room);
	// 		io.to(socket.room).emit('user_names', {list:localRm, currRm:socket.room});
	// 	}
	// });

	socket.on("dm", function(to, msg){
		var from = userList[socket.id];
		socket.broadcast.to(userList2[to]).emit('completed_dm', from, msg);
	});

	socket.on("kick", function(kickee){
		var socket = io.sockets.connected[userList2[kickee]];
		var room = socket.room;
		for(var i in localRm){
			if(localRm[i].includes(socket.username)){
				var index = localRm[i].indexOf(socket.username);
				localRm[i].splice(index, 1);
				socket.leave(socket.room);
				io.to(i).emit('user_names', {list:localRm, currRm:i});
			}
		}
		io.sockets.emit("completed_kick", kickee);
		socket.room = 'lobby';
		socket.join("lobby");
	});

	socket.on("ban", function(banee){
		//this is more like "lock out the user"
		var socket = io.sockets.connected[userList2[banee]]
		var room = socket.room;
		for(var i in localRm){
			if(localRm[i].includes(socket.username)){
				var index = localRm[i].indexOf(socket.username);
				localRm[i].splice(index, 1);
				socket.leave(socket.room);
				io.to(i).emit('user_names', {list:localRm, currRm:i});
			}
		}
		if(!(room in blackList)){
			blackList[room] = [socket.username];
		}else{
			blackList[room].push(socket.username);
		}
		io.sockets.emit("completed_ban", banee);
		socket.room = 'lobby';
		socket.join("lobby");
	});

	socket.on("button_display", function(data){
		var button = data["buttons"];
		//console.log(button);
	});


});
