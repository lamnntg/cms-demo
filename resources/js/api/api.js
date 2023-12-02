import axios from 'axios'

const api = axios.create({
  baseURL: 'https://manager.prismstudio.vn/api/v1',
  headers: {
    'Content-Type': 'application/json',
    timeout: 1000
  }
});

export default api;

