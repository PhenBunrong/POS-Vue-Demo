<template>
<div>
	<div class="content pt-3">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-4">
					<div class="input-group mb-3">
						<select2  v-model="customer.id">
							<option value="0" >Walking Customer</option>
							<option v-for="(x,index) in customers" :key="index" :value="x.id">{{x.name}}</option>
						</select2>
						<div class="input-group-append">
							<button class="btn btn-primary" @click="addCustomer()" type="button"><i class="fa fa-plus"></i></button>
						</div>
					</div>
					<div class="form-group">
						<div class="input-group mb-3">
							<select2  v-model="table.id" name="table">
								<option v-for="(x,index) in tables" :key="index" :value="x.id">{{x.name}}</option>
							</select2>
							<div class="input-group-append">
								<button class="btn btn-primary" @click="addTable()" type="button"><i class="fa fa-plus"></i></button>
							</div>
						</div>
					</div>
					<div class="card table-card">
						<div class="card-body">
							<table class="table">
								<thead>
									<tr>
										<th>N</th>
										<th>Image</th>
										<th>Product</th>
										<th>Qty</th>
										<th>Price</th>
										<th></th>
									</tr>
								</thead>
								<thead>
									<tr v-for="x, index in itemOrder" :key="x.id">
										<th>{{index + 1}}</th>
										<th><img v-bind:src="'img/food/' + x.photo"  alt="food" class="img-size-20"></th>
										<th>{{x.name}}</th>
										<th>
											<div class="btn-group">
												<button type="button" @click="removeItem(x)" class="btn btn-outline-secondary btn-sm">
													<i class="fas fa-minus"></i>
												</button>
												<button type="button" class="btn btn-outline-secondary btn-sm">
													<strong>{{x.qty}}</strong>
												</button>
												<button type="button" @click="orderItem(x)" class="btn btn-outline-secondary btn-sm">
													<i class="fas fa-plus"></i>
												</button>
											</div>
										</th>
										<th>{{x.price + '​ ៛'}}</th>
										<th><i class="fa fa-trash"></i></th>
									</tr>
								</thead>
							</table>
						</div>
						<div class="card-footer">
							<div class="text-total">
								<p>Total:</p>
								<p>{{Total.toLocaleString() + '​ ៛'}}</p>
							</div>
						</div>
						<div class="pay-footer">
							<div class="btn-group btn-block">
								<a type="button" @click="cancelItem()" class="btn-payment btn-danger float-right" ><i class="fas fa-times"> &nbsp;</i>Cancel</a>
								<a type="button" @click="orderModal()" class="btn-payment btn-primary float-right" ><i class="fas fa-cart-plus mr-2"></i>Payment</a>
							</div>
						</div>
					</div>	
				</div>
				<div class="col-lg-8">
					<div class="row">
						<div class="col-sm-6">
							<div class="input-group mb-3">
								<select2  v-model="category">
									<option value="__all" >ទាំងអស់</option>
									<option v-for="(x,index) in categories" :key="index" :value="x.id">{{x.text}}</option>
								</select2>
								<div class="input-group-append">
									<button class="btn btn-primary" @click="addCategory()" type="button"><i class="fa fa-plus"></i></button>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="input-group mb-3">
								<input type="text" class="form-control" @keyup="search_product($event.target.value)" placeholder="Search Product" aria-label="Search Product" aria-describedby="basic-addon2">
								<div class="input-group-append">
									<button class="btn btn-primary" @click="addCategory()" type="button"><i class="fa fa-plus"></i></button>
								</div>
							</div>
						</div>
					</div>
			
					<div class="row">
						<div class="col-sm-2 image" v-for="item in items" :key="item.id">
							<div class="card-image-bg">
								<div class="product-image-thumbs mt-1" @click="orderItem(item)">
									<div class="product-image-thumbs p-0" style="margin: 0 auto;">
										<img v-bind:src="'img/food/' + item.photo"  alt="food" class="img-size-64">
									</div>
								</div>
								<div class="text-center">
									<strong>{{ item.name_kh }}</strong><br>
								</div>
								<div class="ribbon-wrapper">
									<div class="ribbon bg-danger">
										<strong>{{ item.price }}៛</strong><br>
									</div>
								</div>
							</div>
						</div>
					</div>	
				</div>
			</div>
			<div class="modal fade" tabindex='-1' role="dialog" id="order_model">
				<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<form class="form-horizontal" @submit.prevent="onSubmit" @change="form.onKeydow($event)" role="form" method="post" enctype="multiple/form-data">
						<div class="modal-header">
							<h5 class="modal-title">Payment Order</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="row">
							<div class="form-group col-sm-6">
								<label for="total">សរុប</label>
								<input type="text" v-model="Total" class="form-control font-size-order" id="total" placeholder="Total" disabled>
							</div>
							<div class="form-group col-sm-6">
								<label for="total">បញ្ចុះតម្លៃ</label>
								<input type="text" v-model="Discount" class="form-control font-size-order" id="discount" placeholder="Discount">
							</div>
							</div>
							<div class="form-group">
							<label for="TotalPay">ប្រាក់សរុប</label>
							<input type="number" v-model="TotalPay"
								class="form-control font-size-order"
								:class="{'is-invalid' : form.errors.has('TotalPay')}"
								id="TotalPay" name="TotalPay" placeholder="Amount To Pay" disabled>
								<has-error :form="form" field="TotalPay"></has-error>
							</div>
							<div class="form-group">
							<label for="CashIn">ប្រាក់បានទទួល</label>
							<div class="btn-group">
								<button type="button" @click="onCashIn(5000)" class="btn btn-outline-primary"><strong>5,000៛</strong></button>
								<button type="button" @click="onCashIn(10000)" class="btn btn-outline-primary"><strong>10,000៛</strong></button>
								<button type="button" @click="onCashIn(20000)" class="btn btn-outline-primary"><strong>20,000៛</strong></button>
								<button type="button" @click="onCashIn(50000)" class="btn btn-outline-primary"><strong>50,000៛</strong></button>
								<button type="button" @click="onCashIn(100000)" class="btn btn-outline-primary"><strong>100,000៛</strong></button>
							</div>
							<input type="number" v-model="CashIn"
								class="form-control font-size-order mt-1"
								:class="{'is-invalid' : form.errors.has('CashIn')}"
								id="CashIn" name="CashIn" placeholder="Cash In">
								<has-error :form="form" field="CashIn"></has-error>
							</div>

							<div class="form-group md-0">
								<label for="change">ប្រាក់អាប់</label>
								<input type="number" v-model="Change" class="form-control font-size-order" id="change" placeholder="Change" disabled>
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i>Save</button>
						</div>
					</form>
				</div>
				</div>
			</div>
		</div>
		<form-customer :form="form"></form-customer>
		<form-category :form="form"></form-category>
		<form-table :form="form"></form-table>
	</div>
</div>
  

</template>
<script>
import FormCustomer from './FormComponents/FormCustomer';
import FormCategory from './FormComponents/FormCategory';
import FormTable from './FormComponents/FormTable';
export default {
		components : {
			'form-customer' : FormCustomer,
			'form-category' : FormCategory,
			'form-table' : FormTable,
		},
        props:['orders'],
        data(){
          return{
			methods:false,
            category:"__all",
            table:"1",
			tables: {},
			customers: {},
			customer: {
				id:'0'
			},
			items:"",
			itemOrder:[],
			categories:{},
			//No: 0,
			Total: 0,
			Discount: 0,
			TotalPay: 0,
			CashIn: 0,
			Change: 0,
			form: new Form()
          }
        },

        mounted(){
           	this.getItems(this.category);
			this.category_json();
			this.customer_json();
			this.table_json();

			Fire.$on('onCreated', (page=1)=>{
				this.category_json(page);
				this.customer_json();
				this.table_json();
			});
        },
        methods:{

			getItems(value){
				axios.get('product/rows/' + value)
						.then(res => {
							this.items = res.data;
							//console.log(res.data);
						}).catch(error => console.log(error));
			},
			search_product: _.debounce(function(key){
					key.length > 0 ?
						$.get('/json/search-product-json/6/'+key,(res) => {
							this.items = res.data;
						})
					:
						this.getItems("__all");
				},500),
				
			category_json(page = 1) {
                axios.get('/json/category/rows/?page=' + page)
                    .then(res => {
                        this.categories = res.data;
                        //console.log(res.data);
                    })
                    .catch(error => console.log(error));
            }, 
			customer_json(){
				axios.get('/json-customer-rows')
					.then(res => {
						this.customers = res.data;
					});
			},
			table_json(){
				axios.get('/json-table-rows')
					.then(res => {
						this.tables = res.data;
					});
			},
			orderItem(value){
				
				let index =this.itemOrder.findIndex( (x) => x.id === value.id);

				if(index != -1){
					this.itemOrder[index].qty +=1;
					this.Total += value.price;
				}else{
					let order ={
						//No: this.No +=1,
						id: value.id,
						photo: value.photo,
						name: value.name_kh,
						price: value.price,
						qty: 1
					}

					this.Total += value.price;
					this.itemOrder.push(order);
				}
			},

			removeItem(param) {
				let index =this.itemOrder.findIndex( (x) => x.id === param.id);

				if(this.itemOrder[index].qty > 1){
					this.itemOrder[index].qty -=1;
					this.Total -= param.price;
				}else {
					this.Total -= param.price;
					this.itemOrder = this.itemOrder.filter(it => it.id != param.id);
				}

				// it => it.id != param.id Or
				// ƒ (it) {
				// 	return it.id != param.id;
				// }
			},

			orderModal(){
				this.TotalPay = this.Total - this.Discount;
				this.CashIn = 0;
				this.Discount = 0;
				$('#order_model').modal('show');
			},
			cancelItem(){
				this.itemOrder = [];
				this.Total = 0;
			},
			onCashIn(value){
				this.CashIn = parseInt(this.CashIn) + value;
			},
			CustomerLabel({text}){
                return `${text}`
            },
			onSubmit(){
				this.form = new Form({
					Total : this.Total,
					Discount : this.Discount,
					TotalPay : this.TotalPay,
					CashIn : this.CashIn,
					orders : this.itemOrder,
					table : this.table.id,
					customer : this.customer.id,
				});
				
				this.form.post('/save').then(res =>{
					this.itemOrder = [];
					this.Total = 0;
					$('#order_model').modal('hide');
				}).catch(err => console.log(err));
			},

			addCategory(){
				this.method = false;
                this.form.reset();
				$('#modal-category').modal('show');
			},

			addCustomer(){
				this.method = false;
				this.form.reset();
				$('#modal-customer').modal('show');
			},

			addTable(){
                this.method = false;
                this.form.reset();
                $('#modal-table').modal('show');
            },

        },
		watch: {
			category: function(value){
				this.getItems(value);
			},
			Discount: function (value){
				this.TotalPay = this.Total - this.Discount;
				this.Change = this.CashIn - this.TotalPay;
			},
			CashIn: function (value){
				this.TotalPay = this.Total - this.Discount;
				this.Change = this.CashIn - this.TotalPay;
			},
		},

    }

</script>



<style scoped>
.img-size-64 {
    width: 110px;
	height: 110px;
}
.img-size-20 {
    width: 40px;
    height: 40px;
}
.text-center {
    text-align: center !important;
	font-size: 12px;
	margin: 10px;
}
.image{
	margin-right:-24px;
}
.table-card{
	min-height: 600px !important;
	border-radius: 0 !important;
}

.card-image-bg {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid rgba(0, 0, 0, 0.125);
    border-radius: 0.25rem;
}
.text-total{
    justify-content: space-between;
    display: flex;
    font-size: 20px;
    font-weight: bold;
}
.btn-payment {
    display: block;
    font-weight: 800;
    color: #ffff;
    text-align: center;
    width: 100%;
    border: 1px solid transparent;
    padding: 1rem 0.75rem;
    font-size: 1.04rem;
    line-height: 1.5;
}
.btn-payment:hover {
    color: #ffff;
}
.pay-footer {
    padding: 1px;
    background-color: rgba(0,0,0,.03);
    border-top: 0 solid rgba(0,0,0,.125);
}
.card-footer {
    padding: 0.75rem 0.75rem 0 1.25rem !important;
}
.input-group .btn, .input-group > .input-group-append > .input-group-text, .input-group > .input-group-prepend:not(:first-child) > .btn, .input-group > .input-group-prepend:not(:first-child) > .input-group-text, .input-group > .input-group-prepend:first-child > .btn:not(:first-child), .input-group > .input-group-prepend:first-child > .input-group-text:not(:first-child) {
    height: 98%;
}
</style>