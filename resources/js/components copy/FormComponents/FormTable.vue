<template lang="">
    <div>
        <div class="modal fade" id="modal-table">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form @submit.prevent="createTable()"  role="form" method="post">
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
    props:['form'],
    data(){
        return{

        }
    },
    method:{
        createTable(){
            this.form.post('/table').then(res =>{
                    Fire.$emit('onCreated', 1);
                    $('#modal-table').modal('hide');

                })
                .catch(error => console.log(error)); 
        },
    }
}
</script>
<style lang="">
    
</style>