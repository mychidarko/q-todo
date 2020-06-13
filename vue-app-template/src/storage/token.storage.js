import { TOKEN_STORAGE_KEY } from "@/config";

export const get = () => {
	return window.localStorage.getItem(TOKEN_STORAGE_KEY);
};

export const save = token => {
	window.localStorage.setItem(TOKEN_STORAGE_KEY, token);
};

export const destroy = () => {
	window.localStorage.removeItem(TOKEN_STORAGE_KEY);
};

export default { get, save, destroy };
