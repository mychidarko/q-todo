<template>
	<b-navbar toggleable="lg" type="light" class="shadow-sm fixed-top bg-white">
		<b-navbar-brand to="/home">Q Todo App</b-navbar-brand>

		<b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

		<b-collapse id="nav-collapse" is-nav>
			<!-- Right aligned nav items -->
			<b-navbar-nav class="ml-auto">
				<b-nav-item to="/home">Home</b-nav-item>
				<b-nav-item to="/search">Search</b-nav-item>

				<b-nav-item-dropdown right>
					<!-- Using 'button-content' slot -->
					<template v-slot:button-content>
						<em>{{ user.username }}</em>
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
	data: function() {
		return {
			search: "",
			user: User.get()
		}
	},
	methods: {
		logout: function() {
			User.remove();
			this.$router.push("/auth/login");
		}
	}
}
</script>
