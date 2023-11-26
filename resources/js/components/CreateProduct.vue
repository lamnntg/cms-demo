<template>
  <div>
    <div class="modal-body">
      <div class="mb-3">
        <label for="title" class="form-control-label font-weight-bold"
          >Tên sản phẩm:
        </label>
        <input
          v-model="name"
          type="text"
          class="form-control"
          id="title"
          name="name"
          required
        />
      </div>

      <div class="d-flex">
        <div class="mb-3 mr-3">
          <label for="title" class="form-control-label font-weight-bold"
            >Giá:
          </label>
          <input
            type="number"
            v-model="price"
            class="form-control"
            name="price"
            required
          />
        </div>
        <div class="mb-3">
          <label for="title" class="form-control-label font-weight-bold"
            >Thể loại sản phẩm:
          </label>
          <select
            v-model="category"
            class="custom-select"
            name="category"
            required
            style="height: 40px;"
          >
            <option value="" selected>Chọn thể loại sản phẩm</option>
            <option>Test club</option>
          </select>
        </div>
      </div>
      <div class="mb-3">
        <label for="title" class="form-control-label font-weight-bold"
          >Thumnail:
        </label>
        <input type="file" id="thumnail" name="thumnail" required />
      </div>
      <div class="mb-3">
        <label for="description" class="form-control-label font-weight-bold"
          >Các loại sản phẩm:
        </label>
        <div
          v-for="(sku, index) in product_sku"
          :key="sku.id + index"
          class="ml-4"
        >
          <div class="d-flex" style="gap: 1rem">
            <div>
              <label>Mã sản phẩm</label>
              <br />
              <input
                v-model="sku.sku_code"
                class="form-control"
                type="text"
                required
              />
            </div>
            <div>
              <label>Giá</label>
              <br />
              <input v-model="sku.price" class="form-control" type="number" />
            </div>
            <div class="field-color">
              <label>Màu sắc</label>
              <div class="colors d-flex align-items-center">
                <div class="mr-2">
                  <div
                    class="color"
                    :style="{ background: background }"
                    @click="handleShowBoxColor"
                  ></div>
                </div>
                <span>{{ background }}</span>
              </div>
              <transition name="fade">
                <div v-if="showBoxColor" class="box-color">
                  <sketch-picker :value="colors" @input="updateColor" />
                </div>
              </transition>
            </div>
          </div>
          <div class="mt-2">Kích thước / Số lượng</div>
          <div
            v-for="size in ['s', 'm', 'l', 'xl', 'xxl']"
            :key="size"
            class="d-flex align-items-center mt-2"
          >
            <div class="mr-3">
              <select
                class="custom-select"
                name="category"
                required
                style="height: 40px; width: 189px"
                disabled
              >
                <option :value="size">{{ size.toUpperCase() }}</option>
              </select>
            </div>
            <div>
              <input class="form-control" type="number" />
            </div>
          </div>

          <div class="mt-2">Hình ảnh</div>
          <div class="box-image">
            <input ref="file" type="file" hidden multiple accept="image/png, image/gif, image/jpeg" @change="onChangeFile" />
            <div
              :class="['images', active ? 'drag-active' : '']"
              @dragover="dragover"
              @dragleave="dragleave"
              @drop="drop"
            >
              <!-- <div v-for="image in sku.image_sku" :key="image.url" class="detail">
                <div class="d-flex align-items-center p-2 thumbnail">
                  <img
                    class="file-image"
                    :src="image.url"
                    alt=""
                  />
                </div>
                <span class="file-name text-start px-2">{{ image.name}}</span>
                <span class="file-size text-start px-2">{{ image.size }}</span>
                <div class="btn-remove-file">Xóa ảnh</div>
              </div> -->
              <div class="py-5" style="text-align: center">
                <div>Kéo thả hình ảnh vào đây</div>
                <div>hoặc</div>
                <button
                  type="button"
                  class="btn btn-primary btn-icon-split mb-2 mt-3"
                  @click="clickFile"
                >
                  <span class="text">Chọn hình ảnh</span>
                </button>
              </div>
            </div>
          </div>
          <div style="text-align: end">
            <button
              type="button"
              class="btn btn-danger btn-icon-split mb-2 mt-3"
            >
              <span class="icon text-white-50">
                <i class="fas fa-trash"></i>
              </span>
              <span class="text">Xóa loại sản phẩm</span>
            </button>
          </div>
          <button
            type="button"
            class="btn btn-primary btn-icon-split mb-2 mt-3"
          >
            <span class="icon text-white-50">
              <i class="fas fa-plus"></i>
            </span>
            <span class="text">Thêm loại sản phẩm</span>
          </button>
        </div>
      </div>
      <div class="mb-3">
        <label for="description" class="form-control-label font-weight-bold"
          >Chất liệu:
        </label>
        <textarea
          v-model="material"
          class="form-control"
          aria-label="With textarea"
          id="editor"
          name="material"
        ></textarea>
      </div>
      <div class="mb-3">
        <label for="description" class="form-control-label font-weight-bold"
          >Mô tả sản phẩm:
        </label>
        <textarea
          v-model="description"
          class="form-control"
          aria-label="With textarea"
          rows="20"
          id="editor"
          name="description"
        ></textarea>
      </div>
    </div>
    <div class="modal-footer">
      <button type="submit" class="btn btn-primary">Tạo</button>
      <button type="button" class="btn btn-secondary" data-dismiss="modal">
        Đóng
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'CreateProduct',
  data: () => {
    return {
      showBoxColor: false,
      active: false,
      colors: {
        hex: '#194d33',
        hex8: '#194D33A8',
        hsl: { h: 150, s: 0.5, l: 0.2, a: 1 },
        hsv: { h: 150, s: 0.66, v: 0.3, a: 1 },
        rgba: { r: 25, g: 77, b: 51, a: 1 },
        a: 1
      },
      background: '#000',
      name: '',
      category: '',
      price: 0,
      image: '',
      material: '',
      description: '',
      product_sku: [
        {
          id: new Date(),
          sku_code: '',
          color: '',
          image_sku: [
            {
              url: '',
              loading: true,
              name: '',
              size: ''
            }
          ],
          price: 0,
          quantity_size_s: 0,
          quantity_size_m: 0,
          quantity_size_l: 0,
          quantity_size_xl: 0,
          quantity_size_2xl: 0
        }
      ],
      files: []
    };
  },
  methods: {
    handleShowBoxColor() {
      this.showBoxColor = !this.showBoxColor;
    },
    updateColor(color) {
      this.$set(this, 'colors', color);
      this.background = color.hex;
    },
    dragover(event) {
      event.preventDefault();
      this.active = true;
    },
    dragleave() {
      this.active = false;
    },
    drop(event) {
      event.preventDefault();
      this.$refs.file.files = event.dataTransfer.files;
      this.files = event.dataTransfer.files
      console.warn('this',this.files)
    },
    clickFile() {
      if (this.$refs.file) {
        this.$refs.file[0].click();
      }
    },
    onChangeFile(event){
      console.warn('e',event.target.files)
    },
    handleChangeImages(files){
      files.map(file=>{
        return {
          url:URL.createObjectURL(file),
          size: file.size,
          name: file.name
        }
      })
    }
  }
};
</script>

<style lang="scss">
.form-product {
  height: 95vh;
  overflow: auto;
}
.modal-product {
  max-width: 90%;
}
.color {
  width: 20px;
  height: 20px;
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
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
.field-color {
  position: relative;
  cursor: pointer;
  display: flex;
  flex-direction: column;
  .colors {
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
</style>
