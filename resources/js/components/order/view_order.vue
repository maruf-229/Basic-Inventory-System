<template>
    <div>
        <div class="row">
            <router-link to="/order" class="btn btn-primary">Go Back</router-link>
        </div><br>
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12">

                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <!-- Simple Tables -->
                        <div class="card">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Customer Info</h6>
                            </div>
                            <div class="table-responsive">
                                <ul class="list-group">
                                    <li class="list-group-item"><b>Name:</b> {{ orders.name }}</li>
                                    <li class="list-group-item"><b>Phone:</b> {{ orders.phone }}</li>
                                    <li class="list-group-item"><b>Address:</b> {{ orders.address }}</li>
                                    <li class="list-group-item"><b>Date:</b> {{ orders.order_date }}</li>
                                    <li class="list-group-item"><b>Pay Through:</b> {{ orders.payBy }}</li>
                                </ul>
                            </div>
                            <div class="card-footer"></div>
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <!-- Simple Tables -->
                        <div class="card">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Payment Details</h6>
                            </div>
                            <div class="table-responsive">
                                <ul class="list-group">
                                    <li class="list-group-item"><b>Sub Total:</b> {{ orders.sub_total }} $</li>
                                    <li class="list-group-item"><b>Vat:</b> {{ orders.vat }} $</li>
                                    <li class="list-group-item"><b>Total:</b> {{ orders.total }} $</li>
                                    <li class="list-group-item"><b>Pay Amont:</b> {{ orders.pay }} $</li>
                                    <li class="list-group-item"><b>Due Amont:</b> {{ orders.due }} $</li>
                                </ul>
                            </div>
                            <div class="card-footer"></div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-12 mb-4">
                        <!-- Simple Tables -->
                        <div class="card">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Order Details</h6>
                            </div>
                            <div class="table-responsive">
                                <table class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Product Code</th>
                                            <th>Product Photo</th>
                                            <th>Product Qty</th>
                                            <th>Unit Price</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="detail in details" :key="detail.id">
                                            <td>{{ detail.product_name }}</td>
                                            <td>{{ detail.product_code }}</td>
                                            <td><img :src="'/'+detail.image" id="em_photo" alt=""></td>
                                            <td>{{ detail.product_qty }}</td>
                                            <td>{{ detail.product_price }}</td>
                                            <td>{{ detail.subtotal }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer"></div>
                        </div>
                    </div>
                </div>
            </div>


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
    data(){
        return{
            errors:{},
            orders:{},
            details:{},
        }
    },
    created(){
        let id = this.$route.params.id
        axios.get('/api/order/details/'+id)
        .then(({data}) => (this.orders = data))
        .catch(console.log('error'))

        axios.get('/api/order/order_details/'+id)
        .then(({data}) => (this.details = data))
        .catch(console.log('error'))
    },
    methods:{

    }
}
</script>

<style type="text/css" scoped>
    #em_photo{
        height: 40px;
        width: 40px;
    }
</style>
