import axios from "axios";

const AxiosInstance = axios.create({
  baseURL: "http://localhost:8000/api", // Adjust to your Laravel backend
  withCredentials: true,
});

AxiosInstance.interceptors.request.use((config) => {
  const token = localStorage.getItem("token");
  if (token) config.headers["Authorization"] = `Bearer ${token}`;
  return config;
});

export default AxiosInstance;
