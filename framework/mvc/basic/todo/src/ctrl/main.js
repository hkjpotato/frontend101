todoApp.ctrl.main = {
	handleTodoClicked: function(id) {
		//for Model
		Todo.toggle(id);
		Todo.saveAll();
		//for View
		todoApp.view.main.render();
	},

	handleCrossClick: function(id) {
		console.log("CROSS CLICKED FROM CONTROLLER");

		//for Model
		Todo.delete(id);
		Todo.saveAll();
		//for View
		todoApp.view.main.render();
	},

	handleToggleClick: function(id) {
		console.log("TOGGLE CLICKED FROM CONTROLLER");
		//for Model
		Todo.toggle(id);
		Todo.saveAll();
		//for View
		todoApp.view.main.render();
	},

	handleSaveClick: function() {
		var form = document.forms['Todo'];
		var data = {
			id : new Date().getMilliseconds(),
			content: form.content.value,
			completed: false
		}
		Todo.add(data);
		todoApp.view.main.renderTodosList();
		form.reset();
	}
}