<template>
    <div>
              <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">ព័ត៌មានប្រភេទមុខម្ហូប</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/home">Home</a></li>
                        <li class="breadcrumb-item active">ព័ត៌មានអតិថិជន</li>
                        </ol>
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
                                    <a class="btn btn-primary btn-sm" @click="newCategory">
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
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                    <th>លេខ</th>
                                    <th>ឈ្មោះប្រភេទម្ហូបអាហារ</th>
                                    <th>បរិយាយ</th>
                                    <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="cus in category.data" :key="category.id">
                                        <td>{{ cus.id }}</td>
                                        <td>{{ cus.name + " - " + cus.name_kh }}</td>
                                        <td>{{ cus.dsc }}</td>
                                        <td class="project-actions text-right">
                                                <a class="btn btn-primary btn-sm">
                                                    <i class="fas fa-folder">
                                                    </i>
                                                    មើល
                                                </a>
                                                <a class="btn btn-info btn-sm" @click="infoCategory(cus)">
                                                    <i class="fas fa-pencil-alt">
                                                    </i>
                                                    កែប្រែ
                                                </a>
                                                <a class="btn btn-danger btn-sm" @click="deleteCategory(cus.id)">
                                                    <i class="fas fa-trash">
                                                    </i>
                                                    លុប
                                                </a>
                                        </td>
                                    </tr>
                                </tbody>

                                </table>
                            </div>
                            <div class="card-footer">
                                <pagination :data="category" @pagination-change-page="getCategory" :limit="2" align="right"></pagination>
                            </div>
                        </div>
                        </div>
                        <!-- /.card-body -->
                        </div>
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>

        <div class="modal fade" id="modal-category">
                <div class="modal-dialog">
                <div class="modal-content">
                    <form @submit.prevent="method ? editCategory() :createCategory()"  role="form" method="post">
                        <div class="modal-header">
                        <h4 class="modal-title">បញ្ចូលព័ត៌មានថ្ម</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                
                                <label for="name">ឈ្មោះអង្គគ្លេស</label>
                                <input type="text" class="form-control" v-model="form.name" name="name" id="name" placeholder="ឈ្មោះអង្គគ្លេស" autocomplete="name" autofocus required>
                            </div>

                            <div class="form-group">
                                
                                <label for="name_kh">ឈ្មោះខ្មែរ</label>
                                <input type="text" class="form-control" v-model="form.name_kh" name="name_kh" id="name_kh" placeholder="ឈ្មោះខ្មែរ" autocomplete="name_kh" required>
                            </div>

                            <div class="form-group">
                                
                                <label for="dsc">បរិយាយ</label>
                                <input type="text" class="form-control" id="dsc" name="dsc" v-model="form.dsc" placeholder="បរិយាយ" autocomplete="dsc"  >
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
    export default {
        props:['token'],
        data(){
            return{
                methods:false,
                category: {},
                form: new Form({
                    id:"",
                    name:"",
                    name_kh:"",
                    dsc:"",
                    _token: this.token.value
                })
            }

        }, //end data

        mounted(){
            this.getCategory();

            // Reload page or refresh page
            Fire.$on('onCreated', (page=1)=>{
                this.getCategory(page);
            });
        }, //end mounted

        methods: {
            newCategory(){
                this.method = false;
                this.form.reset();
                $('#modal-category').modal('show');
            },
            

            infoCategory(cus){
                this.method = true;
                this.form.reset();

                this.form.fill(cus);
                this.form._token = this.token.value;
                $('#modal-category').modal('show');
            },


            createCategory(){
                this.form.post('/category')
                    .then(res =>{

                        Fire.$emit('onCreated', 1);
                        $('#modal-category').modal('hide');

                    })
                    .catch(error => console.log(error)); 
            },


            editCategory(){
                this.form.put('category/' + this.form.id)
                    .then(res =>{

                        Fire.$emit('onCreated', this.category.current_page);
                        $('#modal-category').modal('hide');
                        console.log(res);
                    })
                    .catch(error => console.log(error));
            },


            getCategory(page = 1) {
                axios.get('/category/get/all?page=' + page)
                    .then(res => {
                        this.category = res.data;
                        //console.log(res.data);
                    })
                    .catch(error => console.log(error));
            }, 
            
            deleteCategory(id){
                /* if(confirm('Are you sure ?')){
                    this.form.delete('customer/' + id)
                        .then(() => {
                            Fire.$emit('onCreated', this.customers.current_page);
                        })
                        .catch(error => console.log(error)); 
                    }*/

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

                                    this.form.delete('category/' + id)
                                        .then(() => {
                                            Vue.swal(
                                                    'Deleted!',
                                                    'Your file has been deleted.',
                                                    'success'
                                                    );
                                            Fire.$emit('onCreated', this.category.current_page);
                                        }).catch(error => console.log(error)); 
                                }
                                })
                        
               
            }
        }//end method 
    }
</script>

<style scoped>
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


</style>