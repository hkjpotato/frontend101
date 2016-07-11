//This view might modify collection as well as storage
//when loaded, loadData to collection, use them to render the selection
//before unload, save collection to storage
todoApp.view.updateTodo = {
	setupUserInterface: function() {
		var keys = [];
		var form = document.forms["Todo"],
			updateBtn = form.commit,
			selectTodo = form.selectTodo;

		Todo.loadAll();
		keys = Object.keys(Todo.collection);
		//render the selection
		for (var i = 0; i < keys.length; i++) {
			var todo = Todo.collection[keys[i]];
			var option = document.createElement("option");
			option.setAttribute("value", todo.id);
			option.text = todo.title;
			selectTodo.add(option, null);
		}

		//when a todo is select,populate the form with selected data
		selectTodo.addEventListener("change", function() {
			var todo = null, key = selectTodo.value;
			if (key) {
				todo = Todo.collection[key];
				form.title.value = todo.title;
				form.content.value = todo.content;
				form.completed.value = todo.completed;
			} else {
				form.title.value = ""
				form.content.value = "";
				form.completed.value = "";
			}
		})
		
		updateBtn.addEventListener("click", todoApp.view.updateTodo.handleUpdateBtnClick)
		window.addEventListener("beforeunload",  function() {
			Todo.saveAll();
		})
	},
	handleUpdateBtnClick: function() {
		var form = document.forms["Todo"],
			selectTodo = form.selectTodo;
		var key = selectTodo.value;
		//not sure if we want to check the logic here
		if (key && Todo.collection[key]) {
			var data = {
				id: key,
				title: form.title.value,
				content: form.content.value,
				completed: !!form.completed.value,
			}
			Todo.update(data);
		} else {
			alert("select a valid todo!");
		}
		form.reset();
	}
}