<template lang="">
    <div>
        <div class="modal fade" id="modal-category">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form @submit.prevent="createCategory" @change="form.onKeydow($event)" role="form" method="post">
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
                                <textarea class="form-control" id="dsc" name="dsc" v-model="form.dsc" placeholder="បរិយាយ" autocomplete="dsc"></textarea>
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
        createCategory(){
            this.form.post('/category')
                .then(res =>{
                    Fire.$emit('onCreated', 1);
                    $('#modal-category').modal('hide');
                }).catch(error => console.log(error)); 
        },
    }
}
</script>
<style lang="">
    
</style>