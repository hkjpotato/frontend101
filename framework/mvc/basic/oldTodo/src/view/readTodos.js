//define the view(how to render the given data to the view) for readTodo
//it does not create a new object, but use the todoApp created by init.js
//it does attach new function to the view attribute/property of the todoApp
//TESTING
console.log("testing ...");
Todo.createTestData();

todoApp.view.readTodos = {
	setupUserInterface: function() {
		var todosList = document.querySelector("ol#todos");
		console.log(todosList)
		var i = 0, keys = [], todo = {}, entry = {};

		//call model by View??
		Todo.loadAll();
		keys = Object.keys(Todo.collection);
		console.log("rendering...");

		for (i = 0; i < keys.length; i++) {
			todo = Todo.collection[keys[i]];
			entry = document.createElement("li");
			entry.setAttribute("id", todo.id);
			entry.setAttribute("class", !!todo.completed ? "completed" : "active");
			entry.appendChild(document.createTextNode(todo.title + " : " + todo.content));
			todosList.appendChild(entry);
		}
	}
}