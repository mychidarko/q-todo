<template>
	<form @submit.prevent="addNewTodo">
		<b-alert  :show="taskError.length > 0" variant="danger" dismissible>{{ taskError }}</b-alert>
		<h3>Add New Task</h3>
		<b-card>
			<div class="center d-flex justify-content-center align-items-center">
				<b-form-input size="md" class="mr-3 ml-1 col-md-9" placeholder="New Todo" v-model="task"></b-form-input>
				<b-button size="md" class="my-2 my-sm-0 col-md-2" type="submit" :disabled="addingTask">
					{{ addingTask ? "Saving New Todo..." : "Add Todo" }}
				</b-button>
			</div>
		</b-card>
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

<style scoped>
.form-row {
	width: 100% !important;
}
</style>
