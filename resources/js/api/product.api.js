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

export const updateProduct = (data, id) => {
  return api.post(`/product/update/${id}`, data, {
    headers: {
      Authorization: 'XxebrehFRKpyorD'
    }
  });
};

export const deleteProduct = (id) => {
  return api.delete(`/product/delete/${id}`, {
    headers: {
      Authorization: 'XxebrehFRKpyorD'
    }
  });
};
