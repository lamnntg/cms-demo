import api from './api';

export const uploadImages = formData => {
  return api.post('/image-upload', formData, {
    headers: {
      Authorization: 'XxebrehFRKpyorD',
      'Content-Type': 'multipart/form-data'
    }
  });
};

export const createProduct = data => {
  return api.post('/product/store', data, {
    headers: {
      Authorization: 'XxebrehFRKpyorD'
    }
  });
};
