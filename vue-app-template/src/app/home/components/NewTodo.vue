<template>
	<div style="margin-top: 90px !important;">
		<b-alert  :show="taskError.length > 0" variant="danger" dismissible>{{ taskError }}</b-alert>
		<b-alert  v-model="success" variant="success" dismissible>Task has been saved!</b-alert>
		<p class="mt-5" v-b-modal="'add-task-modal'">+ Add A Task</p>
		<b-modal id="add-task-modal" title="Add New Task">
			<form @submit.prevent="addNewTodo">
				<b-form-input size="md" placeholder="New Todo" v-model="task" @keydown="success = false" />
			</form>
			<div slot="modal-footer">
				<b-button size="md" type="submit" @click="addNewTodo" :disabled="addingTask">
					{{ addingTask ? "Saving Task..." : "Add Task" }}
				</b-button>
			</div>
		</b-modal>
	</div>
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
					if (res.data.data) {
						this.fetchTodos();
						this.addingTask = false;
						this.task = "";
						this.success = true;
						this.$bvModal.hide('add-task-modal');
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
