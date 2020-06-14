<template>
	<b-navbar toggleable="lg" type="light" class="shadow-sm">
		<b-navbar-brand to="/home">Q Todo App</b-navbar-brand>

		<b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

		<b-collapse id="nav-collapse" is-nav>
			<b-navbar-nav>
				<b-nav-item to="/home">Home</b-nav-item>
			</b-navbar-nav>

			<!-- Right aligned nav items -->
			<b-navbar-nav class="ml-auto">
				<b-nav-form>
					<b-form-input size="sm" class="mr-sm-2" placeholder="Search"></b-form-input>
					<b-button size="sm" class="my-2 my-sm-0" type="submit">Search</b-button>
				</b-nav-form>

				<b-nav-item-dropdown right>
					<!-- Using 'button-content' slot -->
					<template v-slot:button-content>
						<em>User</em>
					</template>
					<b-dropdown-item to="/user">Profile</b-dropdown-item>
					<b-dropdown-item @click="logout">Sign Out</b-dropdown-item>
				</b-nav-item-dropdown>
			</b-navbar-nav>
		</b-collapse>
	</b-navbar>
</template>

<script>
import User from "@/storage/user.storage";

export default {
	name: "Navbar",
	methods: {
		logout: function() {
			User.remove();
			this.$router.push("/auth/login");
		}
	}
}
</script>
