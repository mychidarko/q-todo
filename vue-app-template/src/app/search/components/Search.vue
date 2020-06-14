<template>
  <div style="margin-top: 90px;">
    <b-form-input size="sm" class="mr-sm-2" placeholder="Search..." v-model="keyword" @keyup="handleSearch" @keydown.enter.prevent="handleSearch" />
    <div class="mt-5">
      <div v-if="loading">Loading Your Tasks...</div>
      <div v-else-if="fetchingTasks">
        Digging up {{ keyword }}...
      </div>
      <div v-else>
        <div v-if="tasks.length === 0">
          <h4>We couldn't find {{ keyword }}</h4>
          <p>Try searching for something else</p>
        </div>
        <div v-else>
          <h4 class="mb-0">Your Tasks</h4>
          <small>You can double click to edit</small>
          <div class="mt-3 todos">
            <todo v-for="(todo, index) in tasks" :key="index" :task="todo" :fetchTodos="handleSearch" />
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
      keyword: "",
      tasks: [],
      originalTasks: [],
      user: User.get(),
      fetchingTasks: false,
      loading: true
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
            this.originalTasks = res.data.data;
            this.loading = false;
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
    },
    handleSearch: function() {
      this.fetchingTasks = true;
      let tasks = [];
      
      tasks = this.originalTasks.filter((task) => {
        return String(task.name.toLowerCase()).includes(this.keyword.toLowerCase())
      });
      this.tasks = tasks;
      this.fetchingTasks = false;
    }
  }
};
</script>