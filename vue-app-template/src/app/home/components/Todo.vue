<template>
	<div
		class="todo d-flex"
		@dblclick="inlineEdit = true"
		@mouseleave="inlineEdit = false">
		<div class="form-group form-check">
			<input type="checkbox" class="form-check-input" v-model="isChecked" :id="`task-${task.id}`" @change="updateTask">
			<label class="form-check-label" :for="`task-${task.id}`">
				<div v-if="!inlineEdit">{{ task.name }}</div>
				<input class="inline-edit-input" v-else type="text" v-model="task.name" @keydown.enter="updateTask">
			</label>
		</div>
	</div>
</template>

<script>
import axios from "axios";
import User from "@/storage/user.storage";
import { TOKEN_STORAGE_KEY, API_URL } from "@/config";

export default {
	name: "todo",
	data: function() {
		return {
			isChecked: this.task.status === 'done' ? true : false,
			label: this.task.name,
			inlineEdit: false
		}
	},
	methods: {
		updateTask: function() {
			if (this.task.name.length === 0) {
				this.task.name = this.label;
				this.inlineEdit = false;
				return;
			}
			let data = JSON.stringify({
				todo: this.task.name,
				status: this.isChecked === true ? "done" : "in_progress"
			});
			this.inlineEdit = false;
			let headers = { authorization: `Bearer ${User.get(TOKEN_STORAGE_KEY)}` };
			
			axios({ url: `${API_URL}/todos/${this.task.id}/edit`, method: "post", data, headers })
				.then((res) => {
					console.log(res.data, this.task.id);
					if (res.data.error && res.data.error === "Expired token") {
						User.refreshToken(this.updateTask);
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
	},
	props: {
		task: Object
	}
}
</script>

<style scoped>
.todo {
	border-bottom: 1px solid #cecece !important;
	padding-top: 15px !important;
}
.inline-edit-input {
	z-index: 1000 !important;
}
</style>
