import auth from "./auth/routes";
import home from "./home/routes";
import errors from "./errors/routes";
import timeline from "./timeline/routes";

export default [...home, ...auth, ...timeline, ...errors];
