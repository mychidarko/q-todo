import axios from 'axios';
import { API_URL } from '@/config';
import { USER_STORAGE_KEY } from '@/config';

export function get(selector = null) {
	return selector ? JSON.parse(window.localStorage.getItem(USER_STORAGE_KEY))[selector] : JSON.parse(window.localStorage.getItem(USER_STORAGE_KEY));
}

export function save(user) {
	window.localStorage.setItem(USER_STORAGE_KEY, JSON.stringify(user));
}

export function remove() {
	window.localStorage.removeItem(USER_STORAGE_KEY);
}

export function refreshToken($function = null) {
	return axios
		.get(`${API_URL}/auth/refresh/${get("id")}`)
		.then((res) => {
			let user = get();
			user.token = res.data.token;
			save(user);

			if ($function !== null) return $function();
		});
}

export default { get, save, remove, refreshToken };