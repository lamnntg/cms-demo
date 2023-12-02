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
<<<<<<< Updated upstream
=======

export const updateProduct = (data, id) => {
  return api.post(`/product/update/${id}`, data, {
    headers: {
      Authorization: 'XxebrehFRKpyorD'
    }
  });
};

export const deleteProduct = (data, id) => {
  return api.delete(`/product/delete/${id}`, data, {
    headers: {
      Authorization: 'XxebrehFRKpyorD'
    }
  });
};
>>>>>>> Stashed changes
