<template>
  <div>
    <div class="modal-body">
      <div class="mb-3">
        <label for="title" class="form-control-label font-weight-bold">
          Tên sản phẩm ( <span class="text-danger">*</span> ):
        </label>
        <input
          v-model="name"
          type="text"
          class="form-control"
          id="title"
          name="name"
          placeholder="Nhập tên sản phẩm "
          required
        />
      </div>

      <div class="d-flex">
        <div class="mb-3 mr-3" style="flex: 1">
          <label class="form-control-label font-weight-bold"
            >Giá (VND) ( <span class="text-danger">*</span> ):
          </label>
          <input
            type="number"
            v-model="price"
            class="form-control"
            name="price"
            placeholder="Nhập giá sản phẩm"
            required
          />
        </div>
        <div class="mb-3" style="flex: 1">
          <label class="form-control-label font-weight-bold"
            >Thể loại sản phẩm ( <span class="text-danger">*</span> ):
          </label>
          <select
            v-model="category"
            class="custom-select"
            name="category"
            required
            style="height: 40px"
          >
            <option value="" selected>Chọn thể loại sản phẩm</option>
            <option
              v-for="category in categories"
              :key="category.id"
              :value="category.id"
            >
              {{ category.name }}
            </option>
          </select>
        </div>
      </div>
      <div class="d-flex align-items-center my-3" style="gap: 8px">
        <input type="checkbox" id="checkbox" v-model="is_new" />
        <label class="form-control-label font-weight-bold mb-0" for="checkbox"
          >Sản phẩm mới
        </label>
      </div>
      <div class="mb-3 d-flex align-items-center">
        <label class="form-control-label mb-0 font-weight-bold mr-3"
          >Thumnail ( <span class="text-danger">*</span>
          ):
        </label>
        <div>
          <input
            ref="thumbnail"
            hidden
            type="file"
            accept="image/png, image/gif, image/jpeg"
            @change="onChangeThumbnail"
          />
          <button
            v-if="!thumbnail.url"
            type="button"
            class="btn btn-primary btn-icon-split mb-0"
            @click="clickThumbnailFile"
          >
            <span class="text">Chọn ảnh</span>
          </button>
          <div v-else class="d-flex align-items-center">
            <div class="mr-3 relative">
              <div v-if="thumbnail.loading" class="loading">
                <div class="spinner-border"></div>
              </div>
              <img
                class="thumbnail-product"
                :src="thumbnail.url"
                alt=""
              /><br />
            </div>
            <button
              :disabled="thumbnail.loading"
              class="btn btn-danger"
              @click="thumbnail.url = ''"
            >
              Xóa thumbnail
            </button>
          </div>
        </div>
      </div>
      <div class="mb-3">
        <label for="description" class="form-control-label font-weight-bold"
          >Phân loại sản phẩm ( <span class="text-danger">*</span> ):
        </label>

        <div v-for="sku in product_sku" :key="sku.id" class="ml-2 sku">
          <div class="d-flex align-items-center box-container">
            <!-- Sku attributes -->
            <div class="mr-4">
              <div class="mb-3" style="margin-top: -4px">
                <button
                  type="button"
                  class="btn btn-danger btn-icon-split"
                  @click="removeProductSku(sku.id)"
                  :disabled="product_sku.length < 2"
                >
                  <span class="icon text-white-50">
                    <i class="fas fa-trash"></i>
                  </span>
                  <!-- <span class="text">Xóa loại sản phẩm</span> -->
                </button>
              </div>
              <div class="d-flex" style="gap: 1rem">
                <div>
                  <label>Sku Code ( <span class="text-danger">*</span> )</label>
                  <br />
                  <input
                    v-model="sku.sku_code"
                    class="form-control"
                    type="text"
                    placeholder="#A12345"
                    required
                    style="width: 110px"
                  />
                </div>
                <div>
                  <label>Giá (VND) ( <span class="text-danger">*</span>)</label>
                  <br />
                  <input
                    v-model="sku.price"
                    class="form-control"
                    type="number"
                  />
                </div>

                <div class="field-color">
                  <label>Màu sắc</label>
                  <popper
                    trigger="clickToOpen"
                    :options="{
                      placement: 'top',
                      modifiers: { offset: { offset: '0,10px' } }
                    }"
                  >
                    <div class="popper">
                      <sketch-picker
                        :value="sku.color"
                        @input="color => updateColor(color, sku.id)"
                      />
                    </div>

                    <div slot="reference">
                      <div class="colors d-flex align-items-center">
                        <div class="mr-2">
                          <div
                            class="color"
                            :style="{ background: sku.color.hex }"
                            @click="handleShowBoxColor"
                          ></div>
                        </div>
                        <span>{{ sku.color.hex }}</span>
                      </div>
                    </div>
                  </popper>
                </div>
              </div>
              <div>
                <label class="form-control-label font-weight-bold"
                  >Chất liệu ( <span class="text-danger">*</span> ):
                </label>
                <div>
                  <input
                    v-model="sku[`material`]"
                    class="form-control"
                    type="text"
                    defaultValue=""
                  />
                </div>
              </div>
              <!-- Size -->
              <div class="mt-2">
                Số lượng ( <span class="text-danger">*</span> )
              </div>
              <div>
                <input
                  v-model="sku[`quantity`]"
                  class="form-control"
                  type="number"
                  defaultValue="10"
                />
              </div>
              <div class="mt-2">
                Mô tả ( <span class="text-danger">*</span> )
              </div>
              <div>
                <textarea
                  v-model="sku[`description`]"
                  class="form-control"
                  aria-label="With textarea"
                  rows="3"
                ></textarea>
              </div>
            </div>

            <!-- Image -->
            <div class="mr-4 w-75 h-100 box-image">
              <div
                class="d-flex justify-content-between align-items-center px-2"
              >
                <div>Hình ảnh ( <span class="text-danger">*</span> )</div>
                <button
                  type="button"
                  class="btn btn-primary btn-icon-split"
                  @click.stop="clickFile(sku.id)"
                >
                  <span class="text">Chọn hình ảnh</span>
                </button>
              </div>
              <div class="box-image">
                <input
                  :ref="'file' + sku.id"
                  type="file"
                  hidden
                  multiple
                  accept="image/png, image/gif, image/jpeg"
                  @change="e => onChangeFile(e, sku.id)"
                />
                <div :class="['images relative', active ? 'drag-active' : '']">
                  <div v-if="sku.loading" class="loading">
                    <div class="spinner-border"></div>
                  </div>
                  <div
                    v-if="sku.image_sku.length > 0"
                    class="d-flex flex-wrap"
                    style="gap: 1rem"
                  >
                    <div style="overflow-x: auto">
                      <Container
                        @drop="e => onDrop(e, sku.id)"
                        orientation="horizontal"
                        behaviour="contain"
                      >
                        <Draggable
                          v-for="image in sku.image_sku"
                          :key="image.url"
                          @click.stop=""
                        >
                          <div class="detail" @click.stop="">
                            <div
                              class="d-flex align-items-center p-2 thumbnail"
                              @click.stop=""
                            >
                              <img
                                class="file-image"
                                :src="image.url"
                                alt=""
                                @click.stop=""
                              />
                            </div>
                            <div
                              class="btn-remove-file"
                              @click.stop="removeImage(sku.id, image.url)"
                            >
                              Xóa ảnh
                            </div>
                          </div>
                        </Draggable>
                      </Container>
                    </div>
                  </div>
                  <div v-else class="py-5" style="text-align: center">
                    <div>Kéo thả hình ảnh vào đây</div>
                    <div>hoặc</div>
                    <button
                      type="button"
                      class="btn btn-primary btn-icon-split mb-2 mt-3"
                      @click.stop="clickFile(sku.id)"
                    >
                      <span class="text">Chọn hình ảnh</span>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div>
        <button
          type="button"
          class="btn btn-primary btn-icon-split mb-2"
          @click="addProductSku"
        >
          <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
          </span>
          <span class="text">Thêm loại sản phẩm</span>
        </button>
      </div>
      <div class="mb-3">
        <label for="description" class="form-control-label font-weight-bold"
          >Chất liệu ( <span class="text-danger">*</span> ):
        </label>
        <textarea
          v-model="material"
          class="form-control"
          aria-label="With textarea"
          id="editor"
          name="material"
          placeholder="Vải chính: 73% rayon, 25% viscose, 2% spandex - Lớp lót: 70% satin, 30% polyester"
        ></textarea>
      </div>
      <div class="mb-3">
        <label for="description" class="form-control-label font-weight-bold"
          >Mô tả sản phẩm ( <span class="text-danger">*</span> ):
        </label>
        <textarea
          v-model="description"
          class="form-control"
          aria-label="With textarea"
          rows="10"
          id="editor"
          name="description"
          placeholder="Áo blazer dạng croptop phong cách cá tính và trẻ trung, vải jeans bền, có 2 túi cơi phía trước, thiết kế dài ngang eo trên hông. Vải lót lụa satin mềm mại, thấm hút mồ hôi tốt."
        ></textarea>
      </div>
    </div>
    <div class="modal-footer">
      <button
        type="button"
        class="btn btn-secondary"
        data-dismiss="modal"
        @click="onBack"
      >
        Hủy bỏ
      </button>
      <button
        :disabled="disabledSubmit || isSubmiting"
        type="submit"
        class="btn btn-primary"
        @click="submit"
      >
        {{ isEdit ? 'Cập nhật' : 'Tạo mới' }}
      </button>
    </div>
  </div>
</template>

<script>
import Popper from 'vue-popperjs';
import 'vue-popperjs/dist/vue-popper.css';
import {
  createProduct,
  updateProduct,
  uploadImages
} from './../api/product.api';
import { v4 as uuidv4 } from 'uuid';
import { Container, Draggable } from 'vue-smooth-dnd';
import { applyDrag, generateItems } from '../utils/helper';
import { MATERIAL_OPTIONS } from '../common/constant';

export default {
  name: 'CreateProduct',
  props: {
    isEdit: {
      type: Boolean,
      default: false
    },
    product: {
      type: Object,
      default: () => {}
    },
    categories: {
      type: Array,
      default: () => []
    }
  },
  components: {
    popper: Popper,
    Container,
    Draggable
  },
  data: () => {
    return {
      showBoxColor: false,
      active: false,
      name: '',
      category: '',
      price: '',
      image: '',
      is_new: false,
      material: '',
      description: '',
      product_sku: [
        {
          id: uuidv4(),
          sku_code: '',
          color: {
            hex: '#000000'
          },
          quantity: '',
          description: '',
          image_sku: [],
          price: '',
          material: '',
          quantity_size_s: '',
          quantity_size_m: '',
          quantity_size_l: '',
          quantity_size_xl: '',
          quantity_size_2xl: '',
          loading: false,
          active: false
        }
      ],
      thumbnail: {
        url: '',
        loading: true
      },
      isSubmiting: false,
      items: generateItems(50, i => ({ id: i, data: 'Draggable ' + i })),
      MATERIAL_OPTIONS
    };
  },
  created() {
    if (this.isEdit) {
      console.log('s', this.product);
      this.name = this.product.name;
      this.category = this.product.category_id;
      this.material = this.product.material;
      this.is_new = this.product.is_new;
      this.description = this.product.description;
      this.price = this.product.price;
      this.thumbnail.url = this.product.images[0];
      this.thumbnail.loading = false;
      this.product_sku = this.product.product_skus.map(sku => {
        const {
          id,
          sku_code,
          color,
          price,
          description,
          quantity,
          material,
          quantity_size_s,
          quantity_size_m,
          quantity_size_l,
          quantity_size_xl,
          quantity_size_2xl,
          image_sku
        } = sku;
        return {
          id,
          sku_code,
          color: {
            hex: color
          },
          description,
          description,
          image_sku: image_sku.map(img => {
            return {
              url: img
            };
          }),
          price,
          material,
          quantity,
          quantity_size_s,
          quantity_size_m,
          quantity_size_l,
          quantity_size_xl,
          quantity_size_2xl,
          loading: false,
          active: false
        };
      });
    } else {
      this.product_sku[0].sku_code = this.generateRandomString().toUpperCase();
    }
  },
  computed: {
    disabledSubmit() {
      const {
        name,
        price,
        category,
        material,
        description,
        product_sku,
        thumbnail
      } = this;
      const inValidSku = product_sku.some(
        sku =>
          !sku.price || !sku.sku_code || sku.loading || sku.image_sku.length < 1
      );
      const isInValidSubmit =
        !name ||
        !price ||
        !category ||
        !material ||
        !description ||
        thumbnail.loading ||
        inValidSku;
      return isInValidSubmit;
    }
  },
  methods: {
    onDrop(dropResult, id) {
      const item = this.product_sku.find(e => e.id === id);
      const index = this.product_sku.findIndex(e => e.id === id);
      if (!item) {
        return;
      }
      this.product_sku[index].image_sku = applyDrag(
        this.product_sku[index].image_sku,
        dropResult
      );
    },

    handleShowBoxColor() {
      this.showBoxColor = !this.showBoxColor;
    },
    updateColor(color, id) {
      const product = this.product_sku.find(item => item.id === id);
      product.color = color;
    },
    dragover(event, id) {
      event.preventDefault();
      const product = this.product_sku.find(item => item.id === id);
      product.active = true;
    },
    dragleave(id) {
      const product = this.product_sku.find(item => item.id === id);
      product.active = false;
    },
    validateFile(files) {
      let isValid = true;
      const vm = this;
      Array.from(files).forEach(file => {
        let allowedTypes = [
          'image/jpeg',
          'image/png',
          'image/gif',
          'image/webp',
          'image/jpg',
          'image/svg+xml'
        ];
        if (!allowedTypes.includes(file.type) || file.size > 1024 * 1024 * 10) {
          isValid = false;
          vm.$toast.error(
            'Tệp tin phải có địng dạng là hình ảnh và không được lớn hơn 10MB'
          );
        }
      });
      return isValid;
    },
    drop(event, id) {
      event.preventDefault();
      const product = this.product_sku.find(item => item.id === id);
      if (product.loading) {
        return;
      }
      const isValid = this.validateFile(event.dataTransfer.files);
      if (!isValid) {
        return;
      }
      this.$refs[`file${id}`].files = event.dataTransfer.files;
      this.handleChangeImages(event.dataTransfer.files, id);
    },
    clickFile(id) {
      const product = this.product_sku.find(item => item.id === id);
      if (product.loading) {
        return;
      }
      if (this.$refs[`file${id}`]) {
        this.$refs[`file${id}`][0].click();
      }
    },
    clickThumbnailFile() {
      if (this.$refs.thumbnail) {
        this.$refs.thumbnail.click();
      }
    },
    async onChangeThumbnail(e) {
      const isValid = this.validateFile(e.target.files);
      if (!isValid) {
        return;
      }
      try {
        this.thumbnail.loading = true;
        this.thumbnail.url = URL.createObjectURL(e.target.files[0]);
        const formData = new FormData();
        formData.append('uploads[]', e.target.files[0]);
        const result = await uploadImages(formData);
        if (result.data && result.data[0]) {
          this.thumbnail.url = result.data[0].url;
        }
      } catch (err) {
        console.warn('e', err);
      } finally {
        this.thumbnail.loading = false;
      }
    },
    onChangeFile(event, id) {
      const product = this.product_sku.find(item => item.id === id);
      if (product.loading) {
        return;
      }
      const isValid = this.validateFile(event.target.files);
      if (!isValid) {
        return;
      }
      this.handleChangeImages(event.target.files, id);
    },
    async handleChangeImages(files, id) {
      const product = this.product_sku.find(item => item.id === id);
      const lengthImageSku = product.image_sku.length;
      try {
        product.loading = true;
        const formData = new FormData();
        Array.from(files).forEach(file => {
          formData.append('uploads[]', file);
          product.image_sku.push({
            url: URL.createObjectURL(file),
            size: file.size,
            name: file.name
          });
        });
        const result = await uploadImages(formData);
        for (
          let index = lengthImageSku;
          index < product.image_sku.length;
          index++
        ) {
          product.image_sku[index].url =
            result.data[index - lengthImageSku].url;
        }
      } catch {
        console.warn('err');
      } finally {
        product.loading = false;
      }
    },
    addProductSku() {
      this.product_sku.push({
        id: uuidv4(),
        sku_code: (
          this.name.slice(0, 1) +
          '-' +
          this.generateRandomString()
        ).toUpperCase(),
        color: {
          hex: '#194d33',
          hex8: '#194D33A8',
          hsl: { h: 150, s: 0.5, l: 0.2, a: 1 },
          hsv: { h: 150, s: 0.66, v: 0.3, a: 1 },
          rgba: { r: 25, g: 77, b: 51, a: 1 },
          a: 1
        },
        image_sku: [],
        price: '',
        quantity_size_s: '',
        material: '',
        quantity_size_m: '',
        quantity_size_l: '',
        is_new: false,
        quantity_size_xl: '',
        quantity_size_2xl: '',
        loading: false
      });
    },
    removeProductSku(id) {
      const index = this.product_sku.findIndex(item => item.id === id);
      if (this.product_sku.length > 1) {
        this.product_sku.splice(index, 1);
      }
    },
    getFileSize(size) {
      return size < 1024
        ? size + 'kb'
        : (size / (1024 * 1024)).toFixed(2) + 'MB';
    },
    removeImage(skuId, imageUrl) {
      const product = this.product_sku.find(item => item.id === skuId);
      const index = product.image_sku.findIndex(img => img.url === imageUrl);
      product.image_sku.splice(index, 1);
    },
    submit() {
      const {
        name,
        price,
        category,
        material,
        description,
        product_sku,
        thumbnail,
        is_new
      } = this;
      if (this.disabledSubmit) {
        this.$toast.warning('Hãy điền đầy đủ thông tin trước khi tạo');
        return;
      }
      const product_skus = product_sku.map(sku => {
        const {
          sku_code,
          description,
          image_sku,
          color,
          quantity,
          price,
          material
        } = sku;
        return {
          sku_code,
          color: color.hex,
          price,
          description,
          material,
          quantity: quantity ? Number(quantity) : 0,
          image_sku: image_sku.map(image => image.url)
        };
      });
      const data = {
        name,
        images: thumbnail.url,
        price,
        category_id: category,
        material,
        description,
        is_new: is_new ? 1 : 0,
        product_skus
      };
      const vm = this;
      this.isSubmiting = true;
      if (this.isEdit) {
        this.$toast.info('Đang cập sản phẩm');
        updateProduct(data, this.product.id)
          .then(() => {
            vm.$toast.success('Cập nhật sản phẩm thành công');
            window.location.assign('/admin/product');
          })
          .catch(err => {
            vm.$toast.success('Cập nhật sản phẩm thất bại');
          })
          .finally(() => {
            vm.isSubmiting = false;
          });
      } else {
        this.$toast.info('Đang tạo sản phẩm');
        createProduct(data)
          .then(() => {
            vm.$toast.success('Tạo sản phẩm thành công');
            vm.reset();
          })
          .catch(err => {
            vm.$toast.success('Tạo sản phẩm thất bại');
          })
          .finally(() => {
            vm.isSubmiting = false;
          });
      }
    },
    reset() {
      this.showBoxColor = false;
      this.active = false;
      this.background = '#000';
      this.name = '';
      this.category = '';
      this.price = '';
      this.image = '';
      this.material = '';
      this.is_new = false;
      this.description = '';
      this.product_sku = [
        {
          id: uuidv4(),
          sku_code: '',
          color: {
            hex: '#000000'
          },
          image_sku: [],
          description: '',
          price: '',
          quantity_size_s: '',
          quantity_size_m: '',
          quantity_size_l: '',
          quantity_size_xl: '',
          quantity_size_2xl: '',
          loading: false,
          active: false
        }
      ];
      this.thumbnail = {
        url: '',
        loading: true
      };
      this.isSubmiting = false;
    },
    onBack() {
      window.location.assign('/admin/product');
    },
    generateRandomString() {
      const characters =
        'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
      let result = '';
      for (let i = 0; i < 4; i++) {
        result += characters.charAt(
          Math.floor(Math.random() * characters.length)
        );
      }
      return result;
    }
  }
};
</script>

<style lang="scss" scoped>
.form-product {
  height: 95vh;
  overflow: auto;
}

.modal-product {
  max-width: 90%;
}

.color {
  width: 40px;
  height: 40px;
  border-radius: 4px;
}

.box-color {
  position: absolute;
  top: 100%;
  left: 0;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}

.fade-enter,
.fade-leave-to

/* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}

.field-color {
  position: relative;
  cursor: pointer;
  display: flex;
  flex-direction: column;

  span {
    display: flex;
    flex: 1;
    align-items: center;
  }
}

.icon-remove {
  margin-left: 1rem;
  font-size: 22px;
  cursor: pointer;
  color: #e63946;
}

.box-image {
  background: #fff;
  border-radius: 8px;
  padding: 1rem;
  border-radius: 0.375rem;

  .images {
    text-align: center;
    border: 2px dashed #e7e7e8;
    border-radius: 0.375rem;
    padding: 1rem;
    cursor: pointer;
  }
}

.drag-active {
  border: 2px dashed #4e73df !important;
}

.detail {
  display: flex;
  flex-direction: column;
  width: 10rem;
  box-shadow: 0 0.375rem 1rem 0 rgba(58, 53, 65, 0.12);
  border-radius: 0.3125rem;

  .thumbnail {
    border-bottom: 1px solid #e7e7e8;

    .file-image {
      width: 120px;
      height: 120px;
      object-fit: cover;
      margin: auto;
    }
  }

  .file-name {
    color: #b4b2b7;
    text-align: start;
  }

  .file-size {
    color: #b4b2b7;
    text-align: start;
    font-style: italic;
    font-size: 12px;
    border-bottom: 1px solid #e7e7e8;
    font-weight: bold;
  }

  .btn-remove-file {
    padding: 8px;
    cursor: pointer;
    color: #89868d;

    &:hover {
      background: rgba(58, 53, 65, 0.06);
    }
  }
}

.border-bottom {
  width: 100%;
  height: 1px;
  background: #e7e7e8;
  margin: 1rem 0;
}

.thumbnail-product {
  width: 120px;
  height: 120px;
  object-fit: cover;
}

.relative {
  position: relative;
}

.loading {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  z-index: 10;
  .spinner-border {
    border: 0.25em solid #4e73df !important;
    border-right-color: transparent !important;
  }
}

.name-truncate {
  width: 160px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.sku {
  background: #f0f0f0;
  padding: 1rem;
  border-radius: 8px;
  margin-bottom: 1rem;
}

.custom-select:disabled {
  font-weight: bold;
  color: #000 !important;
  background: white !important;
}
@media screen and (max-width: 1200px) {
  .box-container {
    flex-direction: column;
    align-items: start !important;
    gap: 1rem;
    .box-image {
      width: 100% !important;
      margin-right: 0 !important;
    }
  }
}
</style>
