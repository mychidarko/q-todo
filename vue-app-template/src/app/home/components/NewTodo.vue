<template>
	<form @submit.prevent="addNewTodo">
		<b-alert  :show="taskError.length > 0" variant="danger" dismissible>{{ taskError }}</b-alert>
		<b-alert  v-model="success" variant="success" dismissible>{{ task }} has been added!</b-alert>
		<h4>Add New Task</h4>
		<b-card>
			<div class="center d-flex justify-content-center align-items-center py-0">
				<b-form-input size="md" class="mr-3 ml-1 col-lg-10 col-md-9 col-8" placeholder="New Todo" v-model="task" @keydown="success = false"></b-form-input>
				<b-button size="md" class="my-2 my-sm-0 col-lg-2 col-md-3 col-4" type="submit" :disabled="addingTask">
					{{ addingTask ? "Saving Task..." : "Add Task" }}
				</b-button>
			</div>
		</b-card>
	</form>
</template>

<script>
import axios from "axios";
import User from "@/storage/user.storage";
import { TOKEN_STORAGE_KEY, API_URL } from "@/config";

export default {
	name: "newTodo",
	props: ["fetchTodos"],
	data: function() {
		return {
			task: "",
			taskError: "",
			addingTask: false,
			success: false
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
			let data = JSON.stringify({
				todo: this.task
			});
			let headers = { authorization: `Bearer ${User.get(TOKEN_STORAGE_KEY)}` };
					
			axios({ url: `${API_URL}/todos`, method: "post", data, headers })
				.then((res) => {
					console.log(res.data);
					if (res.data.data) {
						this.fetchTodos();
						this.addingTask = false;
						this.success = true;
					}
					if (res.data.error && res.data.error === "Expired token") {
						User.refreshToken(this.addNewTodo);
					}
				})
				.catch((err) => {
					let errors = String(err).split(" ");
					let errs = "";
			
					for (let index = 0; index < errors.length; index++) {
						const error = errors[index];
						if (index > 0) {
							errs = `${errs} ${error} `;
						}
					}

					console.log(errs);
				});
		}
	}
}
</script>
