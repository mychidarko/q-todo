<template>
  <div class="register center d-flex justify-content-center align-items-center  flex-column">
    <form class="register-form py-4 px-3" @submit.prevent="handleRegister">
      <h4 class="mb-3">Create your Q Todo Account</h4>
      <div class="form-group">
        <label for="username">Username</label>
        <b-form-input
          size="md"
          placeholder="mychi_darko"
          name="username"
          v-model="username"
          @keyup="validateUsername" />
          <small v-if="usernameError.length > 0" class="text-danger">{{ usernameError }}</small>
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <b-form-input
          size="md"
          placeholder="mickdd22@gmail.com"
          name="email"
          v-model="email"
          @keyup="validateEmail" />
          <small v-if="emailError.length > 0" class="text-danger">{{ emailError }}</small>
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
        {{ logginIn ? "Creating your account..." : "Sign Up" }}
      </b-button>
    </form>
    Already have an account? <router-link to="/auth/login">Sign in now</router-link>
  </div>
</template>

<script>
import axios from "axios";
import { API_URL } from "@/config";
import User from "@/storage/user.storage";

export default {
  name: "Register",
  data: function() {
    return {
      username: "",
      usernameError: "",
      email: "",
      emailError: "",
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
    validateEmail: function() {
      let isValid = true;
			if (this.email.length === 0) {
				this.emailError = "Enter a email.";
				isValid = false;
      }
      if (this.email.length > 0 && this.email.length < 5) {
				this.emailError = "Email should be more than four characters.";
				isValid = false;
      }
      if (isValid) this.emailError = "";
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
    handleRegister: function() {
      if (!this.validateUsername() || !this.validateEmail() || !this.validatePassword()) return;
      this.logginIn = true;

      let data = JSON.stringify({
        username: this.username,
        email: this.email,
        password: this.password
      });

      axios({ url: `${API_URL}/auth/register`, method: "post", data })
          .then((res) => {
              console.log("res", res.data);
              if (res.data.error && res.data.error.username) {
                this.usernameError = res.data.error.username;
                this.logginIn = false;
              }
              if (res.data.error && res.data.error.email) {
                this.emailError = res.data.error.email;
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
.register {
  height: calc(100vh - 30px);
}
.register-form {
  min-width: 300px !important;
}
</style>