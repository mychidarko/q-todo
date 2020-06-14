import auth from "./auth/routes";
import home from "./home/routes";
import errors from "./errors/routes";
import settings from "./settings/routes";

export default [
	{
		path: "/",
		component: () => import("./layout/Main.vue"),
		children: [
			{
				path: "/",
				redirect: "/home"
			},
			...home,
			...settings
		]
	},
	...auth,
	...errors,
];
