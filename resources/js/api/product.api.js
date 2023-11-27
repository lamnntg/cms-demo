import api from "./api"

export const uploadImages = (formData)=>{
    return api.post("/image-upload", formData,{
        headers: {
            Authorization: 'XxebrehFRKpyorD',
            "Content-Type": "multipart/form-data"
        }
    })
}