<template>
  <div>
    <div>
      <button
        type="button"
        data-toggle="modal"
        data-target=".bd-example-modal-xl"
        class="btn btn-primary btn-icon-split mb-2"
        @click="redirectToCreate"
      >
        <span class="icon text-white-50">
          <i class="fas fa-plus"></i>
        </span>
        <span class="text">Tạo sản phẩm</span>
      </button>
    </div>
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách orders</h6>
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
                <th>Tên sản phẩm</th>
                <th>Loại sản phẩm</th>
                <th>Giá tiền (VND)</th>
                <th>Chất liệu</th>
                <th>Mô tả</th>
                <th class="text-center">Hành động</th>
              </tr>
            </thead>

            <tbody>
              <tr v-for="product in products" :key="product.id">
                <td>{{ product.name }}</td>
                <td>{{ product.category_id }}</td>
                <td>{{ product.price.toLocaleString() }}đ</td>
                <td>{{ product.material }}</td>
                <td>{{ product.description }}</td>
                <td>
                  <!-- Call to action buttons -->
                  <ul class="list-inline m-0 d-flex justify-content-center">
                    <li class="list-inline-item">
                      <button
                        class="btn btn-primary btn-sm rounded-0"
                        type="button"
                        data-toggle="tooltip"
                        data-placement="top"
                        title="Add"
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
                      >
                        <i class="fa fa-edit"></i>
                      </button>
                    </li>
                    <li class="list-inline-item">
                      <button
                        class="btn btn-danger btn-sm rounded-0"
                        type="button"
                        data-toggle="tooltip"
                        data-placement="top"
                        title="Delete"
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
  </div>
</template>

<script>
import { deleteProduct } from '../api/product.api';
export default {
  name: 'Product',
  props:{
    products:{
      type: Array,
      default:()=>[]
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
      productSelected: this.products[0],
      productRemove: this.products[0],
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
    handleRemove() {
      try {
        this.isSubmiting = true;
        deleteProduct(this.productRemove.id);
        this.$toast.success('Xóa sản phẩm thành công');
      } catch {
        this.$toast.error('Xóa sản phẩm thất bại');
      } finally {
        this.isSubmiting = false;
      }
    }
  }
};
</script>

<style lang="scss" scoped>
.list-inline-item button i {
  width: 18px;
}
</style>
