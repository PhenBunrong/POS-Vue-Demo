<template lang="">
    <div>
        <div class="modal fade" id="modal-customer">
                <div class="modal-dialog">
                <div class="modal-content">
                    <form @submit.prevent="createCustomer()" @change="form.onKeydow($event)" role="form" method="post">
                        <div class="modal-header">
                        <h4 class="modal-title">បញ្ចូលព័ត៌មានថ្ម</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">ឈ្មោះអតិថិជន</label>
                                <input type="text" class="form-control" v-model="form.name" name="name" id="name" placeholder="ឈ្មោះអតិថិជន" autocomplete="name" autofocus required>
                            </div>

                            <div class="form-group">
                                <label for="gender">ភេទ</label>
                                    <select id="gender" name="gender" v-model="form.gender" class="form-control">
                                        <option  value="1">ប្រុស</option>
                                        <option  value="0">ស្រី</option>
                                    </select>
                            </div>

                            <div class="form-group">
                                <label for="phone">លេខទូរស័ព្ទ</label>
                                <input type="text" class="form-control" v-model="form.phone" name="phone" id="phone" placeholder="លេខទូរស័ព្ទ" autocomplete="phone" required>
                            </div>

                            <div class="form-group">
                                <label for="address">អាស័យដ្ខាន</label>
                                <textarea class="form-control" id="address" name="address" v-model="form.address" placeholder="អាស័យដ្ខាន" autocomplete="address"  required></textarea>
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
        createCustomer(){
				this.form.post('/customer').then(res =>{
					Fire.$emit('onCreated', 1);
					$('#modal-customer').modal('hide');

				}).catch(error => console.log(error)); 
			},
    }
}
</script>
<style lang="">
    
</style>