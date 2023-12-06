import axios from 'axios'

const api = axios.create({
  baseURL: process.env.APP_URL + '/api/v1',
  headers: {
    'Content-Type': 'application/json',
    timeout: 1000
  }
});

export default api;

