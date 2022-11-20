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
                                    <a class="btn btn-primary btn-sm" @click="newTable">
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
                                    <th>ឈ្មោះតុ</th>
                                    <th>ពិពណ៏នាអំពីតុ</th>
                                    <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="cus,index in tables.data" :key="index.id">
                                        <td>{{ index+1 }}</td>
                                        <td>{{ cus.name }}</td>
                                        <td>{{ cus.dsc }}</td>
                                        <td class="project-actions text-right">
                                            <a class="btn btn-primary btn-sm">
                                                <i class="fas fa-folder">
                                                </i>
                                                មើល
                                            </a>
                                            <a class="btn btn-info btn-sm" @click="infoTable(cus)">
                                                <i class="fas fa-pencil-alt">
                                                </i>
                                                កែប្រែ
                                            </a>
                                            <a class="btn btn-danger btn-sm" @click="deleteTable(cus.id)">
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
                                <pagination :data="tables" @pagination-change-page="getTable" :limit="2" align="right"></pagination>
                            </div>
                        </div>
                        </div>
                        <!-- /.card-body -->
                        </div>
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>

        <div class="modal fade" id="modal-table">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form @submit.prevent="method ? editTable() : createTable()"  role="form" method="post">
                        <div class="modal-header">
                        <h4 class="modal-title">បញ្ចូលព័ត៌មានតុ</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">ឈ្មោះលេខតុ</label>
                                <input type="text" class="form-control" v-model="form.name" name="name" id="name" placeholder="ឈ្មោះលេខតុ" autocomplete="name" autofocus required>
                            </div>
                            <div class="form-group">
                                <label for="name">ពិពណ៏នាអំពីតុ</label>
                                <textarea class="form-control" v-model="form.dsc" name="name" id="dsc"></textarea>
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
                tables: {},
                form: new Form({
                    id:"",
                    name:"",
                    dsc:"",
                    _token: this.token.value
                })
            }

        }, //end data

        mounted(){
            this.getTable();

            Fire.$on('onCreated', (page=1)=>{
                this.getTable(page);
            });
        }, //end mounted

        methods: {
            newTable(){
                this.method = false;
                this.form.reset();
                $('#modal-table').modal('show');
            },
            
            createTable(){
                this.form.post('/table').then(res =>{
                        Fire.$emit('onCreated', 1);
                        $('#modal-table').modal('hide');

                    })
                    .catch(error => console.log(error)); 
            },

            getTable(page = 1) {
                axios.get('/table/get/all?page=' + page).then(res => {
                        this.tables = res.data;
                        //console.log(res.data);
                    })
                    .catch(error => console.log(error));
            }, 

            infoTable(cus){
                this.method = true;
                this.form.reset();

                this.form.fill(cus);
                this.form._token = this.token.value;
                $('#modal-table').modal('show');
            },


            editTable(){
                this.form.put('table/' + this.form.id).then(res =>{

                        Fire.$emit('onCreated', this.tables.current_page);
                        $('#modal-table').modal('hide');
                        console.log(res);
                    })
                    .catch(error => console.log(error));
            },

            
            deleteTable(id){
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

                        this.form.delete('customer/' + id)
                            .then(() => {
                                Vue.swal(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                        );
                                Fire.$emit('onCreated', this.customers.current_page);
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