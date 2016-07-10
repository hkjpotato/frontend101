//This view might modify collection as well as storage
//when loaded, loadData to collection, use them to render the selection
//before unload, save collection to storage
todoApp.view.deleteTodo = {
	setupUserInterface: function() {
		var keys = [];
		var form = document.forms["Todo"],
			deleteBtn = form.commit,
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

		deleteBtn.addEventListener("click", todoApp.view.deleteTodo.handleDeleteBtnClick)
		window.addEventListener("beforeunload",  function() {
			Todo.saveAll();
		});
	},
	handleDeleteBtnClick: function() {
		var form = document.forms["Todo"],
			selectTodo = form.selectTodo,
			key = selectTodo.value;
		if (key) {
			Todo.delete(key);
			selectTodo.remove(selectTodo.selectedIndex);
		}
	}
}