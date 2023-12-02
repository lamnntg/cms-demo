<template>
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
</template>

<script>
<<<<<<< Updated upstream
=======
import { deleteProduct } from '../api/product.api';
import Pagination from './Pagination.vue';
>>>>>>> Stashed changes
export default {
  name: 'Product',
  methods:{
    redirectToCreate(){
        window.location.href = '/admin/product/create'
    }
<<<<<<< Updated upstream
=======
  },
  components: {
    Pagination
  },
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
      try{
        this.isSubmiting = true
        deleteProduct(this.productRemove.id)
        this.$toast.success('Xóa sản phẩm thành công');
      }
      catch{
        this.$toast.error('Xóa sản phẩm thất bại');
      }
      finally{
        this.isSubmiting = false
      }
    }
>>>>>>> Stashed changes
  }
};
</script>

<style></style>
