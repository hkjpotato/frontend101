//This js introduce Todo as an function obj
function Todo (todoData) {
	this.id = todoData.id;
	this.completed = todoData.completed;
	this.content = todoData.content;
}
//To faciliate querying, use a map instead of array to store the collection of todos
Todo.collection = {};

//STATIC METHODS
//help to convert the data to a todo object 
//is this the so called ORM?
Todo.convertData2Obj = function (data) {
	var todo = new Todo(data);
	return todo;
}

Todo.convertObj2Data = function(todo) {
	var todoData = {};
	todoData.id = todo.id;
	todoData.completed = todo.completed;
	todoData.content = todo.content;
}

Todo.loadAll = function() {
	//declare the variable here instead of in the loop improve performance
	var i = 0,
		key = "",
		keys = [],
		todosDataString = "",
		todosData = {};
	try {
		if (localStorage["todos"]) {
			todosDataString = localStorage["todos"];
		}

	} catch (e) {
		alert("Error when reading from Local Storage\n" + e);
	}
	if (todosDataString) {
		todosData = JSON.parse(todosDataString);
		keys = Object.keys(todosData);
		console.log( keys.length + " todos loaded.");
		//convert the data to obj
		for (i = 0; i < keys.length; i++) {
			key = keys[i];
			Todo.collection[key] = Todo.convertData2Obj(todosData[key]);
		}
	}
}

Todo.saveAll = function() {
	var error = false,
		todosDataString = "",
		numofTodos = Object.keys(Todo.collection).length;
	try {
		//serialization
		todosDataString = JSON.stringify(Todo.collection);
		localStorage["todos"] = todosDataString;
	} catch (e) {
		alert("Error when writing to Local Storage\n" + e);
		error = true;
	}

	if (!error) {
		console.log( numofTodos + " todos saved.");
	}
}

Todo.add = function(data) {
	var todo = new Todo(data);
	Todo.collection[data.id] = todo;
	console.log("Todo id: " + data.id + " content: " + data.content + " added!");
}

Todo.update = function(data) {
	var todo = Todo.collection[data.id];
	var content = data.content;
	var completed = data.completed;

	if (content != todo.content) { todo.content = content;};
	if (completed != todo.completed) { todo.completed = completed;};

	console.log("Todo id: " + data.id + " content: " + data.content + " updated!");
}

Todo.delete = function (id) {
	if (Todo.collection[id]) {
		console.log("Todo " + id + " deleted");
		delete Todo.collection[id];
	} else {
		console.log("There is no Todo with id " + id);
	}
}

Todo.toggle = function(id) {
	if (Todo.collection[id]) {
		console.log("Todo " + id + " toggled");
		Todo.collection[id].completed = !Todo.collection[id].completed;
	} else {
		console.log("There is no Todo with id " + id);
	}
}

Todo.createTestData = function() {
	Todo.collection["0"] = new Todo({
		id: 0,

		content: "running for half hour.",
		completed: false
	});

	Todo.collection["1"] = new Todo({
		id: 1,
		content: "practie DFS algorithms.",
		completed: false
	});

	Todo.collection["2"] = new Todo({
		id: 2,
		content: "have dinner with GF.",
		completed: true
	});
	Todo.saveAll();
}

Todo.clearData = function() {
	if (confirm("Do you reallly want to delete all todos?")) {
		localStorage["todos"] = "{}";
	}
}

Todo.filter = function(param) {
	Todo.collection.filter(function(todo) {
		
	} )
}
