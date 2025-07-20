import axios from "axios";

export function getToken() {
  return localStorage.getItem("token");
}

export function apiAuth(uri) {
  return axios.create({
    baseURL: `http://localhost:8080/api/v1/${uri}`,
    headers: {
      Authorization: `Bearer ${getToken()}`
    }
  });
}
