import auth from "./auth/routes";
import home from "./home/routes";
import errors from "./errors/routes";
import settings from "./settings/routes";

export default [
	{
		path: "/",
		redirect: "/home"
	},
	...home,
	...auth,
	...errors,
	...settings
];
