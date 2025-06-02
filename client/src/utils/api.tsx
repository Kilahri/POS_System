// utils/api.ts
import axios from 'axios';

const API = axios.create({
  baseURL: 'http://localhost:8000', // Laravel server
  withCredentials: true, // Required for Sanctum
});

export const login = async (email: string, password: string) => {
  await API.get('/sanctum/csrf-cookie'); // 👈 Important!
  return API.post('/api/login', { email, password });
};