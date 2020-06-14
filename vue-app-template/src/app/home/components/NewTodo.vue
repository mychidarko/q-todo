<template>
	<form @submit.prevent="addNewTodo">
		<div class="alert alert-danger">{{ taskError }}</div>
		<input type="text" placeholder="New Todo" name="task" v-model="task">
		<button type="submit" :disabled="addingTask">{{ addingTask ? "Saving New Todo..." : "Add Todo" }}</button>
	</form>
</template>

<script>
export default {
	name: "newTodo",
	data: function() {
		return {
			task: "",
			taskError: "",
			addingTask: false
		}
	},
	methods: {
		validate: function() {
			let isValid = true;
			if (this.task.length === 0) {
				this.taskError = "Enter a task.";
				isValid = false;
			} else {
				this.taskError = "";
			}
			return isValid;
		},
		addNewTodo: function(event) {
			event.preventDefault();
			if (!this.validate()) return;

			this.addingTask = true;
			console.log(this.task);
		}
	}
}
</script>
