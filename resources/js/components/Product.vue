<template>
  <div>
    <div class="card shadow mb-4">
      <div
        class="card-header py-3 d-flex justify-content-between align-items-center"
      >
        <h6 class="m-0 font-weight-bold text-primary text-lg">
          Danh sách sản phẩm
        </h6>
        <div>
          <button
            type="button"
            data-toggle="modal"
            data-target=".bd-example-modal-xl"
            class="btn btn-primary btn-icon-split"
            @click="redirectToCreate"
          >
            <span class="icon text-white-50">
              <i class="fas fa-plus"></i>
            </span>
            <span class="text">Tạo sản phẩm</span>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table
            class="table table-bordered"
            id="dataTable"
            width="100%"
            cellspacing="0"
          >
            <thead>
              <tr>
                <th>STT</th>
                <th>Tên sản phẩm</th>
                <th>Loại sản phẩm</th>
                <th>Giá tiền (VND)</th>
                <th>Chất liệu</th>
                <th>Mô tả</th>
                <th class="text-center">Hành động</th>
              </tr>
            </thead>

            <tbody>
              <tr v-for="(product, index) in products" :key="product.id">
                <td>{{ index + 1 }}</td>
                <td>{{ product.name }}</td>
                <td>
                  {{ getCategory(product.category_id) }}
                </td>
                <td>{{ product.price.toLocaleString() }}</td>
                <td>{{ product.material }}</td>
                <td>{{ product.description }}</td>
                <td>
                  <!-- Call to action buttons -->
                  <ul class="list-inline m-0 d-flex justify-content-center">
                    <li class="list-inline-item">
                      <button
                        class="btn btn-primary btn-sm rounded-0"
                        type="button"
                        data-placement="top"
                        data-toggle="modal"
                        data-target=".modal-info"
                        @click="productSelected = product"
                      >
                        <i class="fa fa-info"></i>
                      </button>
                    </li>
                    <li class="list-inline-item">
                      <button
                        class="btn btn-success btn-sm rounded-0"
                        type="button"
                        data-toggle="tooltip"
                        data-placement="top"
                        title="Edit"
                        @click="edit(product.id)"
                      >
                        <i class="fa fa-edit"></i>
                      </button>
                    </li>
                    <li class="list-inline-item">
                      <button
                        class="btn btn-danger btn-sm rounded-0"
                        type="button"
                        data-placement="top"
                        data-toggle="modal"
                        data-target=".modal-delete"
                        @click="productRemove = product"
                      >
                        <i class="fa fa-trash"></i>
                      </button>
                    </li>
                  </ul>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Info modal -->
    <div
      class="modal fade modal-info"
      tabindex="-1"
      role="dialog"
      aria-labelledby="myLargeModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-xl">
        <div v-if="productSelected" class="modal-content">
          <div class="modal-body p-4">
            <div class="d-flex">
              <img
                class="thumbnail"
                :src="productSelected.images ? productSelected.images[0] : ''"
                alt=""
              />
              <div>
                <p
                  class="mb-0 font-weight-bold"
                  style="color: #000; font-size: 24px"
                >
                  {{ productSelected.name }}
                </p>
                <p
                  class="mb-0 text-danger font-weight-semibold"
                  style="font-size: 18px"
                >
                  {{ productSelected.price.toLocaleString() }}đ
                </p>
                <span>{{ productSelected.description }}</span>
              </div>
            </div>
            <p class="text-lg font-weight-bold text-black mt-4 mb-0">Mô tả</p>
            <p class="text-md">
              {{ productSelected.description }}
            </p>
            <p class="text-lg font-weight-bold text-black mt-4 mb-3">
              Phân loại sản phẩm
            </p>
            <div
              v-for="sku in productSelected.product_skus"
              :key="sku.id"
              class="sku"
            >
              <div class="d-flex">
                <div class="flex-1">
                  <div class="grid">
                    <span class="text-lg">Mã sku:</span>
                    <span>{{ sku.sku_code }}</span>
                  </div>
                  <div class="grid">
                    <span class="text-lg">Màu sắc:</span>
                    <div
                      class="color"
                      :style="{
                        background: sku.color
                      }"
                    ></div>
                  </div>
                  <div class="grid">
                    <span class="text-lg">Giá tiền:</span>
                    <span class="text-danger"
                      >{{ sku.price.toLocaleString() }}đ</span
                    >
                  </div>
                  <div class="grid">
                    <span class="text-lg">Số lượng:</span>
                    <span class="text-danger">{{ sku.quantity }}</span>
                  </div>
                </div>
              </div>
              <div class="d-flex mt-4" style="gap: 10px">
                <img
                  v-for="image in sku.image_sku"
                  :key="image"
                  class="sku-img"
                  :src="image"
                  alt=""
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Info modal -->
    <div
      class="modal fade modal-delete"
      tabindex="-1"
      role="dialog"
      aria-labelledby="myLargeModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div v-if="productRemove" class="modal-body p-4">
            <p class="text-md">
              Bạn có đồng ý xóa sản phẩm
              <span class="text-lg text-black font-weight-bold"
                >[ {{ productRemove.name }} ] </span
              >không?
            </p>
            <div style="text-align: end">
              <button class="btn btn-secondary mr-2" data-dismiss="modal">
                Hủy bỏ
              </button>
              <button
                class="btn btn-danger"
                data-dismiss="modal"
                @click="handleRemove"
              >
                Đồng ý
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { deleteProduct } from '../api/product.api';
export default {
  name: 'Product',
  props: {
    products: {
      type: Array,
      default: () => []
    },
    categories: {
      type: Array,
      default: () => []
    }
  },
  methods: {
    redirectToCreate() {
      window.location.href = '/admin/product/create';
    }
  },
  // components: {
  //   Pagination
  // },
  data() {
    return {
      page: 1,
      total: 10,
      productSelected: this.products.length > 0 ? this.products[0] : null,
      productRemove: this.products.length > 0 ? this.products[0] : null,
      isSubmiting: false
    };
  },
  // created(){
  //   this.productSelected = this.products[0]
  // },
  mounted() {
    const searchParams = new URLSearchParams(window.location.search);
    this.page = Number(searchParams.get('page'));
  },
  methods: {
    redirectToCreate() {
      window.location.href = '/admin/product/create';
    },
    getPrice(price) {
      return price.toLocaleString('it-IT', {
        style: 'currency',
        currency: 'VND'
      });
    },
    edit(id) {
      window.location.assign('/admin/product/edit/' + id);
    },
    remove(product) {
      this.productRemove = product;
    },
    async handleRemove() {
      try {
        this.$toast.info('Đang xóa sản phẩm');
        this.isSubmiting = true;
        await deleteProduct(this.productRemove.id);
        this.$toast.success('Xóa sản phẩm thành công');
        this.products = this.products.filter(
          product => product.id !== this.productRemove.id
        );
      } catch (e) {
        this.$toast.error('Xóa sản phẩm thất bại');
      } finally {
        this.isSubmiting = false;
      }
    },
    edit(id) {
      window.location.assign(`/admin/product/edit/${id}`);
    },
    getCategory(id) {
      const category = this.categories.find(
        item => Number(item.id) === Number(id)
      );
      return category?.name || '';
    }
  }
};
</script>

<style lang="scss" scoped>
.sku {
  box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
  padding: 1rem;
  border-radius: 8px;
  margin-bottom: 1rem;
}
.grid {
  display: grid;
  grid-template-columns: 100px 1fr;
  margin-bottom: 8px;
  align-items: center;
  span {
    font-size: 16px;
  }
}
.size {
  display: grid;
  grid-template-columns: 75px 1fr;
  margin-bottom: 4px;
  align-items: center;
  font-size: 16px;
}
.color {
  width: 30px;
  height: 30px;
  border-radius: 8px;
}
.text-black {
  color: #000;
}
.list-inline-item button i {
  width: 18px;
}
.thumbnail {
  width: 120px;
  height: 120px;
  object-fit: cover;
  border-radius: 8px;
  margin-right: 16px;
}
.text-md {
  font-weight: 600;
  font-size: 16px;
}
.flex-1 {
  flex: 1;
}
.sku-img {
  width: 80px;
  height: 80px;
  object-fit: cover;
  border-radius: 8px;
}
.table-size {
  border-collapse: collapse;
  margin: 25px 0;
  font-size: 0.9em;
  font-family: sans-serif;
  thead {
    th {
      font-size: 1rem;
      width: 120px;
      text-align: center;
      border: 1px solid #000;
    }
  }
  tr td {
    font-size: 1rem;
    width: 100px;
    text-align: center;
    border: 1px solid #000;
  }
}
</style>
