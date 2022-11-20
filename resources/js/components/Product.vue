<template>
    <div>
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">ព័ត៌មានអតិថិជន</h1>
                </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
            <div class="container-fluid">
                <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <a class="btn btn-primary btn-sm" @click="newProduct">
                                    <i class="fas fa-plus-circle"></i>
                                    បញ្ចូលព័ត៌មានថ្ម
                                </a>
                            </div>

                            <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                                <div class="input-group-append">
                                <button type="submit" class="btn btn-outline-primary"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                            </div>
                        </div>
                        
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <ul class="products-list product-list-in-card pl-2 pr-2">
                                <li class="item" v-for="pro,index in product.data" :key="product.id">
                                    <div class="product-img">
                                            <img v-bind:src="'img/food/' + pro.photo" alt="Product Image" class="img-size-50">
                                    </div>
                                    <div class="product-info">
                                            <a href="javascript:void(0)" class="product-title"> &nbsp;&nbsp;&nbsp;&nbsp;{{ pro.name_kh   + " - " + pro.name }}
                                                    &nbsp;&nbsp;&nbsp;<span class="badge badge-danger">{{ pro.price +"&nbsp;៛" }}</span>
                                                    <span class="badge badge-primary">{{ pro.category_name }}</span></a>
                                            <div class="float-right">
                                                <a class="btn btn-primary btn-sm" @click="infoProduct(pro)">
                                                        <i class="fas fa-folder">
                                                        </i>
                                                        មើល
                                                    </a>
                                                    <a class="btn btn-info btn-sm" @click="infoProduct(pro)">
                                                        <i class="fas fa-pencil-alt">
                                                        </i>
                                                        កែប្រែ
                                                    </a>
                                                    <a class="btn btn-danger btn-sm" @click="deleteProduct(pro.id)">
                                                        <i class="fas fa-trash">
                                                        </i>
                                                        លុប
                                                    </a>
                                            </div>
                                            <span class="product-description">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ pro.dsc }}
                                            </span>
                                    </div>
                                    
                                </li>
                            </ul>
                        </div>
                                    
                        
                        <div class="card-footer">
                            <pagination :data="product" @pagination-change-page="getProduct" :limit="2" align="right"></pagination>
                        </div>
                    </div>
                    </div>
                    <!-- /.card-body -->
                    </div>
            </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        
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
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"> &nbsp;</i>រក្សាទុក</button>
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
        // props:['category'],
        data(){
            return{
                selected: {
                    id: "",
                    name: "",
                    name_kh: "",
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
            this.getProduct();
            this.chooseImage();
            this.category_json();

            Fire.$on('onCreated', (page=1)=>{
                this.getProduct(page);
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
            newProduct(){
                this.method = false;
                this.action = false;

                // this.selected.id= "";
                // this.selected.name= "";
                // this.selected.name_kh= "";

                this.form.reset();
                $('#modal-product').modal('show');
            },
            

            infoProduct(pro){
                this.method = true;
                this.action = true;

                this.form.reset();
                this.form.fill(pro);

                let find = this.categories.find(({id}) => id === pro.category);

                this.category.id = find.id;
                // this.selected.name= find.name;
                // this.selected.name_kh= find.name_kh;
                $('#modal-product').modal('show');
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

            editProduct(){
                this.form.category = this.category.id;
                this.form.put('product/' + this.form.id)
                    .then(res =>{

                        $('#modal-product').modal('hide');
                        Fire.$emit('onCreated', this.product.current_page);
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

            CategoryLabel({name,name_kh}){
                return `${name} — ${name_kh}`
            },

            BrowseImage(){
                $('#photo').trigger('click');
            },

            getProduct(page = 1) {
                axios.get('/product/get/all?page=' + page)
                    .then(res => {
                        this.product = res.data;
                        //console.log(res.data);
                    })
                    .catch(error => console.log(error));
            }, 
            
            deleteProduct(id){
                Vue.swal({
                        title: 'តើអ្នកប្រាកដឬទេ?',
                        text: "សូមលោកអ្នកជ្រើសរើសព្រម ឬបោះបង់",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'យល់ព្រម'
                        }).then((result) => {
                        if (result.value) {

                            this.form.delete('product/' + id)
                                .then(() => {
                                    Vue.swal(
                                            'Deleted!',
                                            'Your file has been deleted.',
                                            'success'
                                            );
                                    Fire.$emit('onCreated', this.product.current_page);
                                }).catch(error => console.log(error)); 
                        }
                    });
            
            }
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


