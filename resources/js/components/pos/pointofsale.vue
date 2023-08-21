<template>
    <div>
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">POS Dashboard</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">POS</li>
            </ol>
          </div>

          <div class="row mb-3">

            <div class="col-xl-5 col-lg-5">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Expens Insert</h6>
                    <a href="" class="btn btn-info">Add Customer</a>
                </div>

                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th>Name</th>
                                <th>Qty</th>
                                <th>Unit</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="cart in carts" :key="cart.id">
                                <td>{{ cart.product_name }}</td>
                                <td>
                                    <button @click.prevent="decreament(cart.id)" class="btn btn-sm btn-danger" v-if="cart.product_qty >= 2">-</button>
                                    <button class="btn btn-sm btn-danger" v-else="" disabled>-</button>
                                    <input type="text" id="qty_input" readonly :value="cart.product_qty">
                                    <button @click.prevent="increament(cart.id)" class="btn btn-sm btn-success">+</button>
                                </td>
                                <td>{{ cart.product_price }}</td>
                                <td>{{ cart.subtotal }}</td>
                                <td><a style="color: white;" @click="removeItem(cart.id)" class="btn btn-sm btn-primary">X</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">Total Quantity: <strong>{{ qty }}</strong></li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">Sub Total: <strong>${{ subtotal }}</strong></li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">Vat: <strong>{{ vats.vat }}%</strong></li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">Total: <strong>{{ subtotal*vats.vat/100 + subtotal }}</strong></li>
                    </ul>
                    <br>
                    <form @submit.prevent="orderDone">
                        <label for="">Customer Name</label>
                        <select name="" id="" class="form-control" v-model="customer_id">
                            <option :value="customer.id" v-for="customer in customers" :key="customer.id">{{ customer.name }}</option>
                        </select>

                        <label for="">Pay</label>
                        <input type="text" class="form-control" required v-model="pay">

                        <label for="">Due</label>
                        <input type="text" class="form-control" required v-model="due">

                        <label for="">Pay By</label>
                        <select name="" id="" class="form-control" v-model="payBy">
                            <option value="Hand Cash">Hand Cash</option>
                            <option value="Cheque">Cheque</option>
                            <option value="Gift Cards">Gift Cards</option>
                        </select>
                        <br>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                </div>
              </div>
            </div>

            <div class="col-xl-7 col-lg-7">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Products Sold</h6>

                </div>

                <!-- Category wise product start -->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">All Product</a>
                    </li>
                    <li class="nav-item" v-for="category in categories" :key="category.id">
                        <a class="nav-link" @click="subProduct(category.id)" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">{{ category.category_name }}</a>
                    </li>
                    </ul>
                <div class="tab-content" id="myTabContent">
                    <!-- Tab Home start -->
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="card-body">
                            <input type="text" v-model="searchTerm" class="form-control" style="width: 300px;" placeholder="Search Product"><br>
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-6 col-6" v-for="product in filterSearch" :key="product.id">
                                    <button class="btn btn-sm" @click.prevent="addToCart(product.id)">
                                        <div class="card" style="width: 13.5rem;margin-bottom: 5px;">
                                            <img :src="product.image" id="em_photo_pos" class="card-img-top" alt="...">
                                            <div class="card-body">
                                                <h6 class="card-title">{{ product.product_name }}</h6>
                                                <span v-if="product.product_quantity >= 1" class="badge badge-success">Avaialable ({{ product.product_quantity }})</span>
                                                <span v-else=" " class="badge badge-danger">Stock-Out</span>
                                            </div>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Tab Home end -->
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="card-body">
                            <input type="text" v-model="getSearchTerm" class="form-control" style="width: 300px;" placeholder="Search Product"><br>
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-6 col-6" v-for="getProduct in getFilterSearch" :key="getProduct.id">
                                    <button class="btn btn-sm" @click.prevent="addToCart(getProduct.id)">
                                        <div class="card" style="width: 13.5rem;margin-bottom: 5px;">
                                            <img :src="getProduct.image" id="em_photo_pos" class="card-img-top" alt="...">
                                            <div class="card-body">
                                                <h6 class="card-title">{{ getProduct.product_name }}</h6>
                                                <span v-if="getProduct.product_quantity >= 1" class="badge badge-success">Avaialable ({{ getProduct.product_quantity }})</span>
                                                <span v-else=" " class="badge badge-danger">Stock-Out</span>
                                            </div>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Category wise product end -->

              </div>
            </div>

          </div>
          <!--Row-->
        </div>
    </div>
</template>

<script type="text/javascript">

export default{
    created(){
        if(!User.loggedIn()){
            this.$router.push({name:'/'})
        }
    },
    created(){
        this.allProducts();
        this.allCategories();
        this.allCustomers();
        this.cartProducts();
        this.vat();
        Reload.$on('AfetrAdd',() => {
            this.cartProducts();
        })
    },
    data(){
        return{
            customer_id:'',
            pay:'',
            due:'',
            payBy:'',

            products:[],
            categories:[],
            getProducts:[],
            searchTerm:'',
            getSearchTerm:'',
            customers:'',
            carts:[],
            vats:'',
            errors:''
        }
    },
    computed:{
        filterSearch(){
            return this.products.filter(product =>{
                return product.product_name.match(this.searchTerm) || product.product_code.match(this.searchTerm)
            })
        },
        getFilterSearch(){
            return this.getProducts.filter(getProduct =>{
                return getProduct.product_name.match(this.getSearchTerm) || getProduct.product_code.match(this.getSearchTerm)
            })
        },
        qty(){
            let sum = 0;
            for(let i=0; i< this.carts.length; i++){
                sum += (parseFloat(this.carts[i].product_qty));
            }
            return sum;
        },
        subtotal(){
            let sum = 0;
            for(let i=0; i< this.carts.length; i++){
                sum += (parseFloat(this.carts[i].subtotal));
            }
            return sum;
        }
    },
    methods:{
        allProducts(){
            axios.get('/api/product/')
            .then(({data}) => (this.products = data))
            .catch()
        },
        allCategories(){
            axios.get('/api/category/')
            .then(({data}) => (this.categories = data))
            .catch()
        },
        allCustomers(){
            axios.get('/api/customer/')
            .then(({data}) => (this.customers = data))
            .catch(console.log('error'))
        },
        subProduct(id){
            axios.get('/api/get_product/'+id)
            .then(({data}) => (this.getProducts = data))
            .catch()
        },
        //cart methods
        addToCart(id){
            axios.get('/api/addToCart/'+id)
            .then(() => {
                Reload.$emit('AfetrAdd');
                Notification.cart_success()
            })
            .catch()
        },
        cartProducts(){
            axios.get('/api/cart/products/')
            .then(({data}) => (this.carts = data))
            .catch(console.log('error'))
        },
        removeItem(id){
            axios.get('/api/removeItem/'+id)
            .then(() => {
                Reload.$emit('AfetrAdd');
                Notification.cart_delete()
            })
            .catch()
        },
        increament(id){
            axios.get('/api/increament/'+id)
            .then(() => {
                Reload.$emit('AfetrAdd');
                Notification.cart_success()
            })
            .catch()
        },
        decreament(id){
            axios.get('/api/decreament/'+id)
            .then(() => {
                Reload.$emit('AfetrAdd');
                Notification.cart_success()
            })
            .catch()
        },
        vat(){
            axios.get('/api/vats/')
            .then(({data}) => (this.vats = data))
            .catch()
        },
        orderDone(){
            let total = this.subtotal*this.vats.vat/100 + this.subtotal
            var data = {
                qty:this.qty,
                subtotal:this.subtotal,
                customer_id:this.customer_id,
                pay:this.pay,
                due:this.due,
                payBy:this.payBy,
                vat:this.vats.vat,
                total:total
            }

            axios.post('/api/orderDone',data)
            .then(()=> {
                Notification.success()
                this.$router.push({name: 'home'})
            })
            .catch(error => this.errors = error.response.data.errors)
        }
        //end cart methods
    }
}
</script>

<style type="text/css" scoped>
    #em_photo_pos{
        height: 150px;
        width: 214px;
    }
    #qty_input{
        width: 30px;
    }
</style>
