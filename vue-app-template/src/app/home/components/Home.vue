<template>
  <div class="mt-5">
    <new-todo :fetchTodos="fetchTodos" />
    <div class="mt-5">
      <div v-if="fetchingTasks">
        Loading Your Tasks, hold on tight...
      </div>
      <div v-else>
        <div v-if="tasks.length === 0">
          <h4>You don't have any tasks</h4>
          <p>Add tasks to view them here</p>
        </div>
        <div v-else>
          <h4 class="mb-0">Your Tasks</h4>
          <small>You can double click to edit</small>
          <div class="mt-3 todos">
            <todo v-for="(todo, index) in tasks" :key="index" :task="todo" :fetchTodos="fetchTodos" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import User from "@/storage/user.storage";
import { TOKEN_STORAGE_KEY, API_URL } from "@/config";

export default {
  name: "Home",
  data: function() {
    return {
      tasks: [],
      user: User.get(),
      fetchingTasks: true
    }
  },
  mounted: function() {
    this.fetchTodos();
  },
  methods: {
    fetchTodos: function() {
      let token = User.get(TOKEN_STORAGE_KEY);
      let headers = { authorization: `Bearer ${token}` };

      axios({ url: `${API_URL}/todos`, method: "get", headers  })
          .then((res) => {
            if (res.data.error && res.data.error === "Expired token") {
              User.refreshToken(this.fetchTodos);
            }
            if (res.data.data) {
              this.tasks = res.data.data;
              this.fetchingTasks = false;
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
};
</script>