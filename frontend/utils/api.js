import axios from "axios";

export function getToken() {
  return localStorage.getItem("token");
}

export function apiAuth() {
  return axios.create({
    baseURL: "https://tu-backend.com/api",
    headers: {
      Authorization: `Bearer ${getToken()}`
    }
  });
}
