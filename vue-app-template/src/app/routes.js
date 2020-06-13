import auth from "./auth/routes";
import home from "./home/routes";
import errors from "./errors/routes";
import settings from "./settings/routes";

export default [
	...home, ...auth, ...errors, ...settings
];
