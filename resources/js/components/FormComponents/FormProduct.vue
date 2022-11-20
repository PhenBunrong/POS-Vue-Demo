<template lang="">
    <div>
      <div class="modal fade" id="modal-product">
            <div class="modal-dialog modal-xl">
                <div class="modal-content"> 
                    <form @submit.prevent="method ? editProduct() : createProduct()" @keydown="form.onKeydown($event)" role="form" method="post">
                        <div class="modal-header">
                        <h4 class="modal-title">បញ្ចូលព័ត៌មានថ្ម</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <div class="row" >
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="form-group col-sm-6" >
                                            <label for="name">ឈ្មោះអង្គគ្លេស</label>
                                            <input type="text" class="form-control" :class="{ 'is-invalid' : form.errors.has('name') }" v-model="form.name" name="name" id="name" placeholder="ឈ្មោះអង្គគ្លេស" autocomplete="name" autofocus>
                                            <has-error :form="form" field="name"></has-error>
                                        </div>
                                    
                                        <div class="form-group col-sm-6">
                                            <label for="name_kh">ឈ្មោះខ្មែរ</label>
                                            <input type="text" class="form-control" :class="{ 'is-invalid' : form.errors.has('name_kh') }" v-model="form.name_kh" name="name_kh" id="name_kh" placeholder="ឈ្មោះខ្មែរ" autocomplete="name_kh" >
                                            <has-error :form="form" field="name_kh"></has-error>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label for="price">តម្លៃ (រៀល)</label>
                                            <input type="number" min="0" class="form-control" :class="{ 'is-invalid' : form.errors.has('price') }" v-model="form.price" name="price" id="price" placeholder="តម្លៃ (រៀល)" autocomplete="price">
                                            <has-error :form="form" field="price"></has-error>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="category">ប្រភេទហារ</label>
                                            <div class="input-group mb-3">
                                                <select2  v-model="category.id" :class="{ 'is-invalid' : form.errors.has('category')}">
                                                    <option v-for="(x,index) in categories" :key="index" :value="x.id">{{x.text}}</option>
                                                </select2>
                                                <has-error :form="form" field="category"></has-error>
                                            </div>
                                        </div>
                              
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-12" >
                                            <label for="dsc">បរិយាយ</label>
                                            <textarea class="form-control" id="dsc" :class="{ 'is-invalid' : form.errors.has('dsc') }" name="dsc" v-model="form.dsc" placeholder="បរិយាយ" autocomplete="dsc" style="height: 105px;"></textarea>
                                            <has-error :form="form" field="dsc"></has-error>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <label for="photo" class="mb-0">រូបភាព</label>
                                                        <div class="card-tools">
                                                            <button type="button" class="btn btn-tool text-primary" @click="BrowseImage">
                                                                <i class="fas fa-paperclip">&nbsp;</i>ជ្រើសរើសរូបភាព
                                                            </button>
                                                        </div>
                                                </div>
                                                <div class="card-body text-center min--hight">
                                                    <input type="file" :class="{ 'is-invalid' : form.errors.has('photo') }" @change="onImageChange" name="photo" id="photo" class="d-none">
                                                    <img class="img-fluid" v-bind:src="action ? 'img/food/' + this.form.photo : this.form.photo" alt="Photo">
                                                </div>
                                            </div>
                                                    <has-error :form="form" field="photo" id="vali-photo"></has-error>
                                        </div>
                                    </div>
                                </div>
                            </div>                     
                        </div>

                        <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times"> &nbsp;</i>បោះបង់</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"> &nbsp;</i> រក្សាទុក</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
</template>
<script>
    import bsCustomFileInput from 'bs-custom-file-input';
    export default {
        data(){
            return{
                category:{
                    id:1
                },
                action: false,
                methods:false,
                product: {},
                categories: {},
                category:{
                    id:1,
                },
                form: new Form({
                    id:"",
                    name:"",
                    name_kh:"",
                    price:"",
                    dsc:"",
                    photo:"",
                })
            }

        }, //end data

        mounted(){
            this.chooseImage();
            this.category_json();

            Fire.$on('onCreated', (page=1)=>{
				this.category_json();
			});
        }, //end mounted

        methods: {
            category_json(page = 1) {
                axios.get('/json/category/rows/?page=' + page)
                    .then(res => {
                        this.categories = res.data;
                        //console.log(res.data);
                    })
                    .catch(error => console.log(error));
            },
            createProduct(){
                this.form.category = this.category.id;
                this.form.post('/product')
                    .then(res =>{

                        $('#modal-product').modal('hide');
                        Fire.$emit('onCreated', 1);
                    })
                    .catch(error => console.log(error)); 
            },

            chooseImage(){
                bsCustomFileInput.init();
            },
            onImageChange(event){
                let files = event.target.files;
                if(!files.length) return;

                this.action = false;
                
                let reader = new FileReader();
                reader.onload = (file) =>{
                    this.form.photo = file.target.result;
                };
                reader.readAsDataURL(files[0]);
            },

            BrowseImage(){
                $('#photo').trigger('click');
            },
            
        }//end method 
    }
</script>

<style scoped>
    .input-group > .form-control, .input-group > .form-control-plaintext, .input-group > .custom-select, .input-group > .custom-file {
        display: none !important;
    }
    .products-list .product-title {
        font-weight: bold;
        font-size: 14px;
    }

    .products-list .product-description {
        color: #6c757d;
        font-size: 11px;
        display: block;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    a {
        color: #3490dc;
        text-decoration: none;
        background-color: transparent;
    }

    .products-list .product-img img {
        height: 50px;
        width: 50px;
    }
    .modal-dialog {
        max-width: 1300px;
        margin: 1.75rem auto;
    }

    .text-forn-12{
        font-size: 12px;
    }
    .text-forn-14{
        font-size: 14px;
        
    }
    .min--hight{
        min-height: 260px;
    }
    .btn-info {
        color: #fff;
        background-color: #17a2b8;
        border-color: #17a2b8;
        box-shadow: none;
        
    }
    .btn-danger {
        color: #fff;
        background-color: #dc3545;
        border-color: #dc3545;
        box-shadow: none;
        
    }
    .btn-primary {
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
        box-shadow: none;
        
    }
    .btn-info:hover {
        display: inline-block;
        color: #fff;
        font-weight: 400;
        text-align: center;
        vertical-align: middle;
        cursor: pointer;
        user-select: none;
        background-color: #0d6775;
        border: 1px solid transparent;
            border-top-color: transparent;
            border-right-color: transparent;
            border-bottom-color: transparent;
            border-left-color: transparent;
    }
    .btn-danger:hover {
        display: inline-block;
        color: #fff;
        font-weight: 400;
        text-align: center;
        vertical-align: middle;
        cursor: pointer;
        user-select: none;
        background-color: #8b1521;
        border: 1px solid transparent;
            border-top-color: transparent;
            border-right-color: transparent;
            border-bottom-color: transparent;
            border-left-color: transparent;
    }
    .btn-primary:hover {
        display: inline-block;
        color: #fff;
        font-weight: 400;
        text-align: center;
        vertical-align: middle;
        cursor: pointer;
        user-select: none;
        background-color: #115fb3;
        border: 1px solid transparent;
            border-top-color: transparent;
            border-right-color: transparent;
            border-bottom-color: transparent;
            border-left-color: transparent;
            
    }

    #vali-photo{
        display: inline;
    }

</style>