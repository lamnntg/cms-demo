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
export default {
  name: 'Product',
  methods:{
    redirectToCreate(){
        window.location.href = '/admin/create-product'
    }
  }
};
</script>

<style></style>
