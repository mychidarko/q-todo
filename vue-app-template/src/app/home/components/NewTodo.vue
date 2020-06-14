<template>
	<form @submit.prevent="addNewTodo">
		<b-alert  :show="taskError.length > 0" variant="danger" dismissible>{{ taskError }}</b-alert>
		<h4>Add New Task</h4>
		<b-card>
			<div class="center d-flex justify-content-center align-items-center py-0">
				<b-form-input size="md" class="mr-3 ml-1 col-lg-10 col-md-9 col-8" placeholder="New Todo" v-model="task"></b-form-input>
				<b-button size="md" class="my-2 my-sm-0 col-lg-2 col-md-3 col-4" type="submit" :disabled="addingTask">
					{{ addingTask ? "Saving Task..." : "Add Task" }}
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
		addNewTodo: function() {
			if (!this.validate()) return;

			this.addingTask = true;
			console.log(this.task);
		}
	}
}
</script>
