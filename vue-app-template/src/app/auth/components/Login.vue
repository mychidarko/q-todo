<template>
  <div class="login center d-flex justify-content-center align-items-center flex-column">
    <form class="login-form py-4 px-3" @submit.prevent="handleLogin">
      <h4 class="mb-3">Login to Q Todo</h4>
      <div class="form-group">
        <label for="username">Username or Email</label>
        <b-form-input
          size="md"
          placeholder="mychi_darko"
          name="username"
          v-model="username"
          @keyup="validateUsername" />
          <small v-if="usernameError.length > 0" class="text-danger">{{ usernameError }}</small>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <b-form-input
          size="md"
          placeholder="********"
          name="password"
          v-model="password"
          @keyup="validatePassword" />
          <small v-if="passwordError.length > 0" class="text-danger">{{ passwordError }}</small>
      </div>
      <b-button variant="outline-primary" type="submit" :disabled="logginIn">
        {{ logginIn ? "Signing you in..." : "Sign In" }}
      </b-button>
    </form>
    Don't have an account? <router-link to="/auth/register">Sign up now</router-link>
  </div>
</template>

<script>
import axios from "axios";
import { API_URL } from "@/config";
import User from "@/storage/user.storage";

export default {
  name: "Login",
  data: function() {
    return {
      username: "",
      usernameError: "",
      password: "",
      passwordError: "",
      logginIn: false
    }
  },
  methods: {
    validateUsername: function() {
      let isValid = true;
			if (this.username.length === 0) {
				this.usernameError = "Enter a username.";
				isValid = false;
      }
      if (this.username.length > 0 && this.username.length < 5) {
				this.usernameError = "Username should be more than four characters.";
				isValid = false;
      }
      if (isValid) this.usernameError = "";
			return isValid;
    },
    validatePassword: function() {
      let isValid = true;
			if (this.password.length === 0) {
				this.passwordError = "Enter a password.";
				isValid = false;
      }
      if (this.password.length > 0 && this.password.length < 7) {
				this.passwordError = "Password should be more than seven characters.";
				isValid = false;
      }
      if (isValid) this.passwordError = "";
			return isValid;
    },
    handleLogin: function() {
      if (!this.validateUsername() || !this.validatePassword()) return;
      this.logginIn = true;

      let data = JSON.stringify({
        username: this.username,
        password: this.password
      });

      axios({ url: `${API_URL}/auth/login`, method: "post", data })
          .then((res) => {
              console.log("res", res.data);
              if (res.data.error && res.data.error.username) {
                this.usernameError = res.data.error.username;
                this.logginIn = false;
              }
              if (res.data.error && res.data.error.password) {
                this.passwordError = res.data.error.password;
                this.logginIn = false;
              }
              if (res.data.data) {
                User.save(res.data.data);
                this.logginIn = false;
                this.$router.push("/home");
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

<style scoped>
.login {
  height: calc(100vh - 30px);
}
.login-form {
  min-width: 300px !important;
}
</style>