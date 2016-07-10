//Again, you already load init.js and Todo.js, meaning you have todoApp and Todo ready
todoApp.view.addTodo = {
	/*  
		This view might modify the data in the map obj (collection) and data in persistent storage (localStorage)
		
		thus:
		1. when loaded, get the collection ready by Todo.loadAll();
		2. before unload, ensure the storage is update by Todo.saveAll();
		3. In between, Todo.add(data) only in charges of updating the the map object(collection)
	*/
	setupUserInterface : function() {
		var saveBtn = document.forms['Todo'].commit;
		//load storage to obj map (Todo.collection)
		Todo.loadAll();
		//attach click event listener
		saveBtn.addEventListener("click", todoApp.view.addTodo.handleSaveBtnClick);
		//attach beforeload event listener to ensure the storage is updated
		window.addEventListener("beforeunload", function() {
			Todo.saveAll();
		});
	},
	handleSaveBtnClick: function() {
		console.log("being called");
		var form = document.forms['Todo'];
		console.log(form);
		var data = {
			id : new Date().getMilliseconds(),
			title: form.title.value,
			content: form.content.value,
			completed: false
		}
		console.log(data);
		Todo.add(data);
		console.log(Todo.collection);
	}
}