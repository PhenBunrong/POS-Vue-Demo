<template lang="">
        <div>
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-5">
                        <h1 class="m-0 text-dark">Export</h1>
                    </div><!-- /.col -->
                    <div class="col-md-7">
                        <form action="" method="get">
                          <div class="row">
                              <div class="col-md-5">
                                  <input type="date" name="start_date" class="form-control" value="">
                              </div>
                              <div class="col-md-5">
                                  <input type="date" name="end_date" class="form-control" value="">
                              </div>
                              <div class="col-md-2">
                                <button class="btn btn-outline-primary btn-flat">Submite</button>
                              </div>
                          </div>
                        </form>
                      </div>
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
            </div>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                    <th>No</th>
                                    <th>Table</th>
                                    <th>User</th>
                                    <th>Customer</th>
                                    <th>Total Pay</th>
                                    <th>Cash In</th>
                                    <th width="10px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="cus,index in items.data" :key="index.id">
                                        <td>{{ index+1 }}</td>
                                        <td>{{ cus.tables.name }}</td>
                                        <td>{{ cus.users.name }}</td>
                                        <td v-if="cus.customers == null">Not Customer</td>
                                        <td v-if="cus.customers != null">{{ cus.customers.name }}</td>
                                        <td>{{ cus.totalPay }}៛</td>
                                        <td>{{ cus.cashIn }}៛</td>
                                        <td class="project-actions">
                                            <a class="btn btn-primary btn-sm">
                                                <i class="fas fa-folder">
                                                </i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr class="bg-secondary">
                                        <td colspan="3"></td>
                                        <td>Total: </td>
                                        <td>{{total}}៛</td>
                                        <td colspan="2"></td>
                                    </tr>
                                </tbody>

                                </table>
                            </div>
                            <div class="card-footer">
                                <pagination :data="items" @pagination-change-page="getExport" :limit="2" align="right"></pagination>
                            </div>
                        </div>
                        </div>
                        <!-- /.card-body -->
                        </div>
                </div><!-- /.container-fluid -->
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return{
            method: false,
            items:{},
        }
    },
    mounted(){
        this.getExport();

        // Reload page or refresh page
        Fire.$on('onCreated', (page=1)=>{
            this.getExport(page);
        });
    },
    computed : {
        total: function() {
            let sum = 0;
            return this.items.data.reduce((sum, item) => sum + item.totalPay, 0);
        }
    },
    methods:{
        getExport(page = 1){
            axios.get('/export-order/get/all?page=' + page)
                .then(res => {
                    this.items = res.data;
                    // let totalItem = this.items.data.forEach(function(key){
                    //                     console.log(key.totalPay)
                    //                 })->sum();
                    //                 console.log(totalItem)
                    // this.total =  totalItem;
                    
                })
                .catch(error => console.log(error));
        },
    },
    watch:{
        
    }
}
</script>
<style lang="">
    
</style>