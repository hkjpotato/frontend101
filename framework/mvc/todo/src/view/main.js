//define the view(how to render the given data to the view) for readTodo
//it does not create a new object, but use the todoApp created by init.js
//it does attach new function to the view attribute/property of the todoApp
//TESTING
todoApp.view.main = {
	render: function() {
		//call model by View??
		Todo.loadAll();
		//function is used to create a closure
		//the context(this) of the function belongs to who called it
		todoApp.view.main.renderTodosList();
		todoApp.view.main.renderAddTodo();
	},
	renderAddTodo: function() {
		var saveBtn = document.forms['Todo'].commit;
		//load storage to obj map (Todo.collection)
		Todo.loadAll();
		//attach click event listener
		saveBtn.addEventListener("click", todoApp.ctrl.main.handleSaveClick);
		//attach beforeload event listener to ensure the storage is updated
		window.addEventListener("beforeunload", function() {
			Todo.saveAll();
		});
	},
	renderTodosList: function() {
		var todosList = document.querySelector("ol#todos");
		//clear existing list elements
		while( todosList.firstChild ){
		  todosList.removeChild( todosList.firstChild );
		}

		var keys = Object.keys(Todo.collection);

		for (var i = 0; i < keys.length; i++) {
			var todo = Todo.collection[keys[i]];

			//todo content 
			var entry = document.createElement("li");
			entry.id = todo.id;
			// entry.setAttribute("class", !!todo.completed ? "completed" : "active");
			entry.className = !!todo.completed ? "completed" : "active";
			entry.key = todo.id;
			entry.addEventListener("dbclick", function() {
				//for event delegation and edit function
				console.log("double clicked");
			});

			//toggle button
			var toggleButton = document.createElement("input");
			toggleButton.type = "checkbox";
			toggleButton.checked = todo.completed;
			toggleButton.key = todo.id;
			toggleButton.addEventListener("click", function(todo) {
				//use closure
				return function() {
					todoApp.ctrl.main.handleToggleClick(todo.id);
				}
			}(todo));

			//cross link
			var crossButton = document.createElement("button");
			var crossNode = document.createTextNode("X");
			crossButton.appendChild(crossNode);
			crossButton.key = todo.id;
			crossButton.addEventListener("click", function() {
				//store id to the dom element
				console.log(this.key);
				todoApp.ctrl.main.handleCrossClick(this.key);
			});


			entry.appendChild(toggleButton)
			entry.appendChild(document.createTextNode(todo.content));
			entry.appendChild(crossButton);
			todosList.appendChild(entry);
		}
	}
}