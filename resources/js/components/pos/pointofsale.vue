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
                            <tr>
                                <td><a href="#">Name</a></td>
                                <td>Qty</td>
                                <td>Unit</td>
                                <td>Total</td>
                                <td><a href="#" class="btn btn-sm btn-primary">X</a></td>
                            </tr>
                            <tr>
                                <td><a href="#">Name</a></td>
                                <td>Qty</td>
                                <td>Unit</td>
                                <td>Total</td>
                                <td><a href="#" class="btn btn-sm btn-primary">X</a></td>
                            </tr>
                            <tr>
                                <td><a href="#">Name</a></td>
                                <td>Qty</td>
                                <td>Unit</td>
                                <td>Total</td>
                                <td><a href="#" class="btn btn-sm btn-primary">X</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">Total Quantity: <strong>56</strong></li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">Sub Total: <strong>$5000</strong></li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">Vat: <strong>35 %</strong></li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">Total: <strong>5600</strong></li>
                    </ul>
                    <br>
                    <form action="">
                        <label for="">Customer Name</label>
                        <select name="" id="" class="form-control" v-model="customer_id">
                            <option v-for="customer in customers" :key="customer.id">{{ customer.name }}</option>
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
                                    <a href="#">
                                        <div class="card" style="width: 13.5rem;margin-bottom: 5px;">
                                            <img :src="product.image" id="em_photo_pos" class="card-img-top" alt="...">
                                            <div class="card-body">
                                                <h6 class="card-title">{{ product.product_name }}</h6>
                                                <span v-if="product.product_quantity >= 1" class="badge badge-success">Avaialable ({{ product.product_quantity }})</span>
                                                <span v-else=" " class="badge badge-danger">Stock-Out</span>
                                            </div>
                                        </div>
                                    </a>
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
                                    <a href="#">
                                        <div class="card" style="width: 13.5rem;margin-bottom: 5px;">
                                            <img :src="getProduct.image" id="em_photo_pos" class="card-img-top" alt="...">
                                            <div class="card-body">
                                                <h6 class="card-title">{{ getProduct.product_name }}</h6>
                                                <span v-if="getProduct.product_quantity >= 1" class="badge badge-success">Avaialable ({{ getProduct.product_quantity }})</span>
                                                <span v-else=" " class="badge badge-danger">Stock-Out</span>
                                            </div>
                                        </div>
                                    </a>
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
    },
    data(){
        return{
            products:[],
            categories:[],
            getProducts:[],
            searchTerm:'',
            getSearchTerm:'',
            customers:'',
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
    }
}
</script>

<style type="text/css" scoped>
    #em_photo_pos{
        height: 150px;
        width: 214px;
    }
</style>
